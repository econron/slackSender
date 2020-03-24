@extends('layouts.app')
@section('content')
    <form method="post" action="{{ route('edit.complete', ['id' => $id]) }}">
        @csrf
        <dt>チャンネル名</dt>
        <dd>{{ $remind['channel_name'] }}</dd>
        <input type="hidden" name="channel_name" value="{{ $remind['channel_name'] }}">
        <dt>ウェブフックアドレス</dt>
        <dd>{{ $remind['webhook_address'] }}</dd>
        <input type="hidden" name="webhook_address" value="{{ $remind['webhook_address'] }}">
        <dt>リマインド内容</dt>
        <dd>{{ $remind['remind_content'] }}</dd>
        <input type="hidden" name="remind_content" value="{{ $remind['remind_content'] }}">
        <dt>締め切り日</dt>
        <dd>{{ $remind['deadline'] }}</dd>
        <input type="hidden" name="deadline" value="{{ $remind['deadline'] }}">
        <input type="submit" value="登録する">
        <button formaction="{{ route('add.back') }}">戻る</button>
    </form>
@endsection

