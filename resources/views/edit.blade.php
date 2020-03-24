@extends('layouts.app')
@section('content')
    <form method="post" action="{{ route('edit.confirm',['id' => $id]) }}">
        @csrf
        <table>
            <tr>
                <th>チャンネル名</th>
                <td><input type="text" name="channel_name" value="{{ $remind->channel_name }}"></td>
            </tr>
            <tr>
                <th>ウェブフックアドレス</th>
                <td><input type="text" name="webhook_address" value="{{ $remind->webhook_address }}"></td>
            </tr>
            <tr>
                <th>リマインド内容</th>
                <td><textarea row="8" name="remind_content" value="{{ $remind->remind_content }}"></textarea></td>
            </tr>
            <tr>
                <th>締め切り日</th>
                <td><input type="datetime-local" name="deadline" value="{{ $remind->deadline }}"></td>
            </tr>
        </table>
        <input type="submit" value="通知する内容を確認する">
    </form>
    <button><a href="{{ route('reminds') }}">更新しない</a></button>
@endsection
