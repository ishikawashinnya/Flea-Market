@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="container__ttl">
        <h1>銀行振込情報</h1>
    </div>
    <div class="message">
        <p>
        ご利用ありがとうございます。<br>
        下記リンクから振込先詳細をご確認いただき、<br>
        手続きを進めていただきますようお願いいたします。
        </p>
    </div>
    <div class="bank__info">
        <p><strong>振込指示詳細:</strong> <a href="{{ $hosted_instructions_url }}" target="_blank" class="bank__info-link">振込詳細を確認</a></p>
    </div>
    <div class="back__home">
        <a href="{{ route('home') }}" class="button">ホームに戻る</a>
    </div>
</div>
@endsection