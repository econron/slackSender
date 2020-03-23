<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $reminds = DB::table('reminds')->get();

            foreach($reminds as $remind){
                // Webhook URL
                $url = $remind->webhook_address;

                // メッセージ
                $message = array(
                    "username"   => "UPCROSS締め切りの神様",
                    "icon_emoji" => ":slack:",
                    "attachments" => array(
                        array(
                            "text" => "<!here> \n$remind->remind_content",
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
        })->weekdays()->at('10:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
