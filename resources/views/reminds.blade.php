@extends('layouts.app')
@section('content')
    <h1>締め切りの神様</h1>
    <h3>締め切り日をすぎた通知は赤文字で表示されます。</h3>
    <table border="1">
        <tr>
            <th>チャンネル名</th>
            <th>リマインド内容</th>
            <th>Webhookアドレス</th>
            <th>締め切り日</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($reminds as $remind)
            <tr style="{{ $remind->deadline < $today ? print "color: #FF0000;" : " " }}">
                <td><div>{{ $remind->channel_name }}</div></td>
                <td><div>{{ $remind->remind_content }}</div></td>
                <td><div>{{ $remind->webhook_address }}</div></td>
                <td><div>{{ $remind->deadline }}</div></td>
                <td><div><a href="{{ route('edit',  ['id' => $remind->id ]) }}">編集する</a></div></td>
                <td><div><a href="{{ route('delete', ['id' => $remind->id ]) }}">削除する</a></div></td>
            </tr>
        @endforeach
    </table>
    <button><a href="{{ route('adds') }}">通知を追加する</a></button>
@endsection
