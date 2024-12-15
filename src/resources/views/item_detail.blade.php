@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}" />
@endsection

@section('content')
<div class="detail__content">
    <div class="content__left">
        <div class="item__img">
            <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}">
        </div>
    </div>

    <div class="content__right">
        <div class="item__name">
            <p>{{ $item->name }}</p>
        </div>
        <div class="brand__name">
            <p>ブランド名</p>
        </div>
        <div class="item__price">
            <p>&yen;{{ number_format($item->price) }}(値段)</p>
        </div>
        <div class="icon">
                @if (in_array($item->id, $userLikes))
                    <form action="{{ route('destroy.like', $item->id) }}" method="POST" class="item__like-form">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="like__form-btn">
                            <img src="{{ asset('icon/star.svg') }}" alt="お気に入り解除">
                            <span class="total__number">{{ $likes }}</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('store.like') }}" method="POST" class="item__like-form">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="like__form-btn">
                            <img src="{{ asset('icon/star.svg') }}" alt="お気に入り登録">
                            <span class="total__number">{{ $likes }}</span>
                        </button>
                    </form>
                @endif
            <div class="icon__img">
                <a href="{{ route('comment', $item->id) }}" class="commetn__link">
                    <img src="{{ asset('icon/balloon.svg') }}" alt="吹き出し">
                </a>
                <span class="total__number">{{ $comments->count() }}</span>
            </div>
        </div>
        <div class="buy__link">
            @if (is_null($sold_item))
                @if (Auth::check() && Auth::id() === $item->user_id)
                    <a href="{{ route('edit.sell', ['id' => $item->id]) }}" class="buy__link-btn">出品情報を変更する</a>
                @else
                    <a href="{{ route('buy', ['item_id' => $item->id]) }}" class="buy__link-btn">購入する</a>
                @endif
            @else
                <p class="buy__link-message">この商品は売り切れました</p>
            @endif
        </div>
        <div class="item__information">
            <div class="information__ttl">
                <h3>商品説明</h3>
            </div>
            <p class="description__text">{{ $item->description }}</p>
        </div>
        <div class="item__information">
            <div class="information__ttl">
                <h3>商品の情報</h3>
            </div>
            <div class="information__groupe">
                <div class="groupe__ttl">
                    <p>カテゴリー</p>
                </div>
                <div class="groupe__item">
                    <p class="category__name">
                        {{ optional($category_item)->name }}
                    </p>
                    @if($item->subcategories->isNotEmpty())
                        <p class="subcategory__name">
                            {{ $item->subcategories->first()->name }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="information__groupe">
                <div class="groupe__ttl">
                    <p>商品の状態</p>
                </div>
                <div class="groupe__item">
                    <p class="condition__name">{{ $item->condition->condition }}</p>
                </div>
            </div>
        </div>
        <div class="item__information">
            <div class="information__ttl">
                <h3>出品者</h3>
            </div>
            <div class="seller__link">
                <a href="{{ route('selleritem', $item->user->id) }}" class="seller__item-link">
                    <div class="user__profile"> 
                        <div class="profile__img">
                            <img src="{{ $profileImgUrl }}" alt="画像">
                        </div>
                        <div class="profile__name">
                            <p>{{ $item->user->name }}</p>
                        </div>
                        <div class="icon__img">
                            <img src="{{ asset('icon/rightarrow.svg') }}" alt="画像">
                        </div>
                    </div>
                </a>
            </div>
        </div>  
    </div>
</div>
@endsection