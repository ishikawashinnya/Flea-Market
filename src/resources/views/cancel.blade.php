@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/result.css') }}" />
@endsection

@section('content')
<div class="content__warp">
    <div class="card">
        <div class="content__message">
            <p class="message">ご購入をキャンセルしました。</p>
        </div>
        
        <div class="content__link">
            <a class="link__btn" href="{{ route('mypage') }}">
                マイページへ移動
            </a>
        </div>
    </div>  
</div>
@endsection