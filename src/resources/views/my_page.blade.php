@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}" />
@endsection

@section('header')
<div class="header__right">
    <form action="/" method="GET" class="header__search">
        @csrf
        <div class="text__search">
            <input type="text" name="word" class="text__search-input" placeholder="なにをお探しですか？" value="{{ request('word') }}">
        </div>    
    </form>

    <nav class="header__nav">
        <ul class="header__nav-list">
            @if (Auth::check())
                <li class="header__nav-item">
                    <form action="/logout" method="post" class="logout">
                        @csrf
                        <button class="header__nav-button">ログアウト</button>
                    </form>
                </li>
                <li class="header__nav-item">
                    <a href="{{ route('home') }}" class="header__nav-link">トップページ</a>
                </li>
            @else
                <li class="header__nav-item">
                    <a href="{{ route('login') }}" class="header__nav-link">ログイン</a>
                </li>
                <li class="header__nav-item">
                    <a href="{{ route('register') }}" class="header__nav-link">会員登録</a>
                </li>
            @endif
            <li class="header__nav-item--sell">
                <a href="#" class="header__nav-link--sell">出品</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="mypage__content">
    <div class="content__header">
        <div class="header__profile">
            <div class="user__profile">
                <div class="profile__img">
                    <img class="face__icon" src="{{ $profileImgUrl }}" alt="画像">
                </div>
                <div class="profile__name">
                    <p>{{ $user->name }}</p>
                </div>
            </div>
            <div class="profile__edit">
                <a href="" class="profile__edit-link">プロフィールを編集</a>
            </div>
        </div>
        <div class="header__tab">
            <div class="tab__item">
                <a href="{{ route('mypage') }}" class="tab__link {{ request('tab') === null ? 'active' : '' }}">出品した商品</a>
            </div>
            <div class="tab__item">
                <a href="{{ route('mypage', ['tab' => 'buys']) }}" class="tab__link {{ request('tab') === 'buys' ? 'active' : '' }}">購入した商品</a>
            </div>
        </div>
    </div>

    <div class="content__main">
        @foreach($items as $item)
            <div class="card">
                <div class="item__img">
                    <a href="#" class="detail__link">
                        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" >
                    </a>
                    @if (in_array($item->id, $soldItems))
                        <div class="card__message">
                            <p class="sold__message">sold</p>
                        </div>
                    @endif
                    <div class="card__item">
                        <p class="item__price">&yen;{{ $item->price }}</p>
                    </div> 
                </div>
                <div class="item__name">
                    <a href="#" class="detail__link">
                        <p>{{ $item->name }}</p>
                    </a>
                </div>
            </div>
        @endforeach
    </div> 
</div>
@endsection