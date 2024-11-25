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
                <p class="item__price">&yen;{{ number_format($item->price) }}</p>
            </div>
        </div>
        <div class="content__groupe">
            <h3 class='groupe__ttl'>支払い方法</h3>
            <div class="payment__method">
                @if (isset($profile))
                    @if ($profile->payment_method == 'credit_card')
                        <p>クレジットカード</p>
                    @elseif ($profile->payment_method == 'convenience_store')
                        <p>コンビニ払い</p>
                    @elseif ($profile->payment_method == 'bank_transfer')
                        <p>銀行振込み</p>
                    @else
                        <p>クレジットカード</p>
                    @endif
                @else
                    <p>配送先情報が登録されていません</p>
                @endif
            </div>
            <a href="{{ route('edit.method', ['item_id' => $item->id]) }}" class="change__link">変更する</a>
        </div>
        <div class="content__groupe">
            <h3 class='groupe__ttl'>配送先</h3>
            <div class="shipping__address">
                @if (isset($profile))
                <label>配送先氏名</label>
                <p class="shipping__name">{{ $profile->shipping_name }}様</p>
                <label>配送先住所</label>
                <p class="postcode">〒{{ $profile->postcode }}</p>
                <p class="address">{{ $profile->address }}</p>
                <p class="building">{{ $profile->building }}</p>
                @else
                <p>配送先情報が登録されていません</p>
                @endif
            </div>
            <a href="{{ route('edit.address', ['item_id' => $item->id]) }}" class="change__link">変更する</a>
        </div>
    </div>

    <div class="content__right">
        <div class="payment__information">
            <div class="information__item-price">
                <p class="information__ttl">商品代金</p>
                <p class="information__value">&yen;{{ number_format($item->price) }}</p>
            </div>
            <div class="information__payment-price">
                <p class="information__ttl">支払金額</p>
                <p class="information__value">&yen;{{ number_format($item->price) }}</p>
            </div>
            <div class="information__payment-method">
                <p class="information__ttl">支払い方法</p>
                <div class="information__value">
                    @if (isset($profile))
                    @if ($profile->payment_method == 'credit_card')
                        <p>クレジットカード</p>
                    @elseif ($profile->payment_method == 'convenience_store')
                        <p>コンビニ払い</p>
                    @elseif ($profile->payment_method == 'bank_transfer')
                        <p>銀行振込み</p>
                    @else
                        <p>クレジットカード</p>
                    @endif
                @else
                    <p>配送先情報が登録されていません</p>
                @endif
                </div>
            </div>
        </div>
        <form action="{{ route('checkout') }}" method="POST" class="buy__form">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="form__button">
                <button class="form__button-submit" type="submit">購入する</button>
            </div>
        </form>
    </div>
</div>
@endsection