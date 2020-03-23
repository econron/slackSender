@extends('layouts.app')
@section('content')
    通知を送信しました。
    <button><a href="{{ route('reminds') }}">スラック通知一覧</a></button><br>
    <button><a href="{{ route('reminds') }}">ホーム画面</a></button>
@endsection
