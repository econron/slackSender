<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reminds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemindDataController extends Controller
{
    public function show_reminds(){
        $reminds = DB::table('reminds')->get();
        return view('reminds', ['reminds' => $reminds]);
    }

    public function back_to_add_page(Request $request){
        $remind = $request->all();
        return view('adds', ['remind' => $remind]);
    }

    public function add_confirm(Request $request){
        $remind = $request->all();
        return view('confirm', ['remind' => $remind]);
    }

    public function add_complete(Request $request){
        $remind = new Reminds();
        $slack_remind = $request->all();

        $remind->channel_name = $slack_remind['channel_name'];
        $remind->remind_content = $slack_remind['remind_content'];
        $remind->webhook_address = $slack_remind['webhook_address'];
        $remind->deadline = $slack_remind['deadline'];

        $remind->save();

        return view('complete');

    }

    public function delete_reminds($id){
        DB::table('reminds')->where('reminds.id','=', $id)->delete();
       $reminds = DB::table('reminds')->get();
        return view('reminds', ['reminds' => $reminds]);
    }

    public function show_edit_reminds($id){

        $edit_remind
            = DB::table('reminds')
            ->where('reminds.id', '=', $id)
            ->get()
            ->first();

        return view('edit', ['remind' => $edit_remind, 'id' => $id]);
    }

    public function edit_confirm_reminds(Request $request, $id){

        $edit_remind = $request->all();

        return view('editconfirm', ['remind' => $edit_remind, 'id'=> $id]);
    }

    public function edit_complete(Request $request, $id){
        $updated_remind = $request->all();
        DB::table('reminds')->where('reminds.id', '=', $id)
            ->update(
                ['channel_name' => $updated_remind['channel_name'],
                 'webhook_address'=> $updated_remind['webhook_address'],
                 'remind_content' => $updated_remind['remind_content'],
                 'deadline' => $updated_remind['deadline']]
            );
        return view('editcomplete');
    }
}
