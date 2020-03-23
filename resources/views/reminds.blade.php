@extends('layouts.app')
@section('content')
    @foreach($reminds as $remind)
        <div>{{ $remind->channel_name }}</div>
        <div>{{ $remind->remind_content }}</div>
        <div>{{ $remind->webhook_address }}</div>
        <div>{{ $remind->deadline }}</div>
        <div><a href="{{ route('edit',  ['id' => $remind->id ]) }}">編集する</a></div>
        <div><a href="{{ route('delete', ['id' => $remind->id ]) }}">削除する</a></div>
    @endforeach
    <div><a href="{{ route('adds') }}">通知を追加する</a></div>
@endsection
