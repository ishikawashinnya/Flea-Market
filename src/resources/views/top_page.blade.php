@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/top_page.css') }}" />
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
                    <a href="{{ route('mypage') }}" class="header__nav-link">マイページ</a>
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
<div class="top__content">
    <div class="content__header">
        <div class="header__tab">
            <a href="{{ route('home') }}" class="tab__link {{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        </div>
        <div class="header__tab">
            <a href="{{ route('home') }}?tab=mylist" class="tab__link {{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
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
                        <div class="item__like">    
                            @if (Auth::check())
                                @if (in_array($item->id, $likes))
                                    <form action="{{ route('destroy.like', $item->id) }}" method="POST" class="item__like-form">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" class="like__form-btn">
                                            <img src="{{ asset('icon/heart_color.svg') }}" alt="お気に入り解除" class="heart-icon">
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('store.like') }}" method="POST" class="item__like-form">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" class="like__form-btn">
                                            <img src="{{ asset('icon/heart.svg') }}" alt="お気に入り登録" class="heart-icon">
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
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