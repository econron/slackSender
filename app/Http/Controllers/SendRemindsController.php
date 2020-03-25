<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendRemindsController extends Controller
{
    public function send_remind(){
        $reminds = DB::table('reminds')->get();

        foreach($reminds as $remind){
            // Webhook URL
            $url = $remind->webhook_address;

            //締め切り日まであと何営業日あるかを確認する処理をした上でtextに渡す。
            $deadline = $remind->deadline;
            $rest_days = $this->rest_days($deadline);

            // メッセージ
            $message = array(
                "username"   => "締め切りの神様",
                "icon_emoji" => ":slack:",
                "attachments" => array(
                    array(
                        "text" =>
                            "<!here> \n$remind->remind_content \n締め切り日は$deadline".
                            "です。"."\n締め切りまで$rest_days".
                            "営業日です。\n本日も頑張りましょう。" ,
                    ),
                )
            );

            //メッセージをスラックに送る処理
            $this->curl_slack($message, $url);

        }

        return view('sendcomplete');

    }

    public function rest_days($deadline){

        setlocale(LC_ALL, 'ja_JP.UTF-8');

        //csvファイルを読み込む
        $national_holidays_csv = new \SplFileObject(database_path('syukujitsu.csv'));

        //ファイル読み込み時の各種設定
        $national_holidays_csv->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        //土日の配列
        $holidays = ['Sat','Sun'];

        //国民の休日の配列
        $national_holidays = [];

        //国民の休日の配列番号
        $number_in_national_holidays = 0;

        //csvファイルから1行読み出すごとに
        //①国民の休日に１ついれる
        //②配列番号を増やす
        foreach ($national_holidays_csv as $national_holiday_csv){
            $national_holidays[$number_in_national_holidays] = $national_holiday_csv[0];
            $number_in_national_holidays++;
        }

        //締め切り日と本日の日付、差分を取得する。
        $dead = strtotime($deadline);

        $today = new DateTime('today');
        $to = strtotime($today->modify('-1 day')->format('Y-m-d H:i:s'));

        $span = abs($dead - $to)/(60*60*24);

        //締め切り日数のカウント
        $rest_days = 0;

        //上記２つの配列のうちどれかに入ってなければ平日に1カウントする
        for($i = 0; $i < $span; $i++){
            $to += (60*60*24);
            if(!in_array(date("D", $to), $holidays) &&
                !in_array(date("Y/m/d", $to), $national_holidays)){
                $rest_days++;
            }
        }

        return $rest_days;
    }

    public function curl_slack($message,$url){
        // メッセージをjson化
        $message_json = json_encode($message);

        // payloadの値としてURLエンコード
        $message_post = "payload=".urlencode($message_json);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message_post);
        curl_exec($ch);
        curl_close($ch);
    }
}

