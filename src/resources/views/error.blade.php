@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/error.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="container__ttl">
        <h1>エラーが発生しました</h1>
    </div>
    <div class="message">
        <p class="error__message">
            {{ $message }}
        </p>
    </div>
    <div class="back__home">
        <a href="{{ route('home') }}" class="button">ホームに戻る</a>
    </div>
</div>
@endsection