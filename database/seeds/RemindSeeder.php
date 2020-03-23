<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::table('reminds')->insert(array(
            0 => array(
                'id' => 1,
                'channel_name' => '実験通知',
                'remind_content' => '実験通知１に送るメッセージです',
                'webhook_address' => '',
                'deadline' => new DateTime(),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ),
            1 => array(
                'id' => 2,
                'channel_name' => '実験通知２',
                'remind_content' => '実験通知２に送るメッセージです',
                'webhook_address' => '',
                'deadline' => new DateTime(),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ),
        ));
        DB::commit();

    }
}
