@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment_method.css') }}" />
@endsection

@section('content')
<div class="edit__content">
    <div class="content__header">
        <h2>支払い方法の変更</h2>
        <div class="alert">
            @if(session('success'))
                <div class="alert__success">
                    <p class="alert__message">{{ session('success')}}</p> 
                </div>
            @endif
        </div>
    </div>

    <div class="content__main">
        <form action="{{ route('update.method') }}" method="post" class="profile__form">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="item_id" value="{{ $item_id }}">

            <div class="form__input">
                <label class="input__label">
                    <input type="radio" name="payment_method" value="credit_card" class="input__item" {{ $profile->payment_method == 'credit_card' ? 'checked' : '' }} checked>
                    <p class="input__name">クレジットカード</p>
                </label> 
            </div>
            
            <div class="form__input">
                <label class="input__label">
                    <input type="radio" name="payment_method" value="convenience_store" {{ $profile->payment_method == 'convenience_store' ? 'checked' : '' }}>
                    <p class="input__name">コンビニ払い</p>
                </label>
            </div>
            
            <div class="form__input">
                <label class="input__label">
                    <input type="radio" name="payment_method" value="bank_transfer" class="input__item" {{ $profile->payment_method == 'bank_transfer' ? 'checked' : '' }}>
                    <p class="input__name">銀行振込み</p>
                </label>
            </div>
            
            <div class="form__button">
                <button class="form__button-submit" type="submit" onclick="return confirm('支払い方法を変更しますか？')">更新する</button>
            </div>
        </form>
        <div class="back__link">
            <a href="{{ route('buy', ['item_id' => $item->id]) }}" class="back__link-btn">購入ページに戻る</a>
        </div>
    </div>
</div>
@endsection