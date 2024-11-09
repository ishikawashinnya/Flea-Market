@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}" />
@endsection

@section('header')
<div class="header__right">
    <form action="/mypage" method="GET" class="header__search">
        @csrf
        <div class="text__search">
            <input type="text" name="word" class="text__search-input" placeholder="なにをお探しですか？" value="{{ request('word') }}">
        </div>    
    </form>

    <nav class="header__nav">
        <ul class="header__nav-list">
            <li class="header__nav-item">
                <form action="/logout" method="post" class="logout">
                    @csrf
                    <button class="header__nav-button">ログアウト</button>
                </form>
            </li>
            <li class="header__nav-item">
                <a href="{{ route('home') }}" class="header__nav-link">トップページ</a>
            </li>
            <li class="header__nav-item">
                <a href="#" class="header__nav-link--sell">出品</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="detail__content">
    <div class="content__left">
        <div class="item__img">
            <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
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
            <p>&yen;{{ $item->price }}(値段)</p>
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
                <img src="{{ asset('icon/balloon.svg') }}" alt="吹き出し">
                <span class="total__number">{{ $comments->count() }}</span>
            </div>
        </div>
        <form action="" class="buy__form">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="form__btn">
                <button class="form__button-submit" type="submit">購入する</button>
            </div>
        </form>
        <div class="item__description">
            <h3>商品説明</h3>
            <p class="description__text">{!! nl2br(e($item->description)) !!}</p>
        </div>
        <div class="item__information">
            <h3 class="information__ttl">商品の情報</h3>
            <div class="information__groupe">
                <div class="groupe__ttl">
                    <p>カテゴリー</p>
                </div>
                <div class="groupe__item">
                    @foreach($category_items as $category_item)
                        <p class="category__name">{{ $category_item->name }}</p>
                    @endforeach
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
    </div>
</div>
@endsection