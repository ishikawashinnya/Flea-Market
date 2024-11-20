@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}" />
@endsection

@section('content')
<div class="buy__content">
    <div class="content__left">
        <div class="item__information">
            <div class="item__img">
                <img src="{{ asset('storage/item_images/' . $item->img_url) }}" alt="商品画像">
            </div>
            <div class="item__detail">
                <p class="item__name">{{ $item->name }}</p>
                <p class="item__price">&yen;{{ $item->price }}</p>
            </div>
        </div>
        <div class="content__groupe">
            <h3 class='groupe__ttl'>支払い方法</h3>
            <p class="payment__method">現在の支払い方法</p>
            <a href="" class="change__link">変更する</a>
        </div>
        <div class="content__groupe">
            <h3 class='groupe__ttl'>配送先</h3>
            <div class="shipping__address">
                <p class="postcode">〒{{ $profile->postcode }}</p>
                <p class="address">{{ $profile->address }}</p>
                <p class="building">{{ $profile->building }}</p>
            </div>
            <a href="{{ route('edit.address', ['item_id' => $item->id]) }}" class="change__link">変更する</a>
        </div>
    </div>

    <div class="content__right">
        <div class="payment__information">
            <div class="information__item-price">
                <p class="information__ttl">商品代金</p>
                <p class="information__value">&yen;{{ $item->price }}</p>
            </div>
            <div class="information__payment-price">
                <p class="information__ttl">支払金額</p>
                <p class="information__value">&yen;{{ $item->price }}</p>
            </div>
            <div class="information__payment-method">
                <p class="information__ttl">支払い方法</p>
                <p class="information__value">コンビニ払い</p>
            </div>
        </div>
        <form action="" class="buy__form">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="form__button">
                <button class="form__button-submit" type="submit">購入する</button>
            </div>
        </form>
    </div>
</div>
@endsection