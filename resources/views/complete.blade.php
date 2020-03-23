@extends('layouts.app')
@section('content')
    メッセージを登録しました。
    <button><a href="{{ route('reminds') }}">スラック通知一覧に戻る</a></button>
@endsection
