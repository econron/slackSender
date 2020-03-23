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

            $deadline = $remind->deadline;

            // メッセージ
            $message = array(
                "username"   => "UPCROSS締め切りの神様",
                "icon_emoji" => ":slack:",
                "attachments" => array(
                    array(
                        "text" => "<!here> \n$remind->remind_content \n締め切り日まで" ,
                    ),
                )
            );

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

        return view('sendcomplete');

    }
}
