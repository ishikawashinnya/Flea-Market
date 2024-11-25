@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_address.css') }}" />
@endsection

@section('content')
<div class="edit__content">
    <div class="content__header">
        <h2>住所の変更</h2>
        <div class="alert">
            @if(session('success'))
                <div class="alert__success">
                    <p class="alert__message">{{ session('success')}}</p> 
                </div>
            @endif
            @if(session('error'))
                <div class="form__error">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <div class="content__main">
        <form action="{{ route('update.address') }}" method="post" class="profile__form">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="item_id" value="{{ $item_id }}">

            <div class="form__input">
                <label for="shipping_name">配送先氏名</label>
                <input type="text" name="shipping_name" id="shipping_name" value="{{ old('shipping_name', $profile->shipping_name ?? '') }}" placeholder = "配送先氏名" >
                <div class="form__error">
                    @error('shipping_name')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__input">
                <label for="postcode">郵便番号</label>
                <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}" placeholder = "111-1111" >
                <div class="form__error">
                    @error('postcode')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__input">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $profile->address ?? '') }}" placeholder = "東京都渋谷区千駄ヶ谷1-2-3" >
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__input">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $profile->building ?? '') }}" placeholder = "千駄ヶ谷マンション123" >
                <div class="form__error">
                    @error('building')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__button">
                <button class="form__button-submit" type="submit">更新する</button>
            </div>
        </form>
        <div class="back__link">
            <a href="{{ route('buy', ['item_id' => $item->id]) }}" class="back__link-btn">購入ページに戻る</a>
        </div>
    </div>
</div>
@endsection