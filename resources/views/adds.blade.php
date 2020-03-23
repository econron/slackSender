@extends('layouts.app')
@section('content')
    追加ページ
    <form method="post" action="{{ route('add.confirm') }}">
        @csrf
        <table>
            <tr>
                <th>チャンネル名</th>
                <td><input type="text" name="channel_name" value="{{ isset($remind['channel_name']) ? $remind['channel_name'] : "" }}"></td>
            </tr>
            <tr>
                <th>ウェブフックアドレス</th>
                <td><input type="text" name="webhook_address" value="{{ isset($remind['webhook_address']) ? $remind['webhook_address'] : "" }}"></td>
            </tr>
            <tr>
                <th>リマインド内容</th>
                <td><textarea row="8" name="remind_content" value="{{ isset($remind['remind_content']) ? $remind['remind_content'] : "" }}"></textarea></td>
            </tr>
            <tr>
                <th>締め切り日</th>
                <td><input type="datetime-local" name="deadline" value="{{ isset($remind['deadline']) ? $remind['deadline'] : "" }}"></td>
            </tr>
        </table>
        <input type="submit" value="通知する内容を確認する">
    </form>
@endsection
