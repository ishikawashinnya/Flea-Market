@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('header')
<form action="/" method="GET" class="header__search">
    @csrf
    <div class="text__search">
        <input type="text" name="word" class="text__search-input" placeholder="なにをお探しですか？" >
    </div>    
</form>

<nav class="header__nav">
    <ul class="header__nav-list">
        @if (Auth::check())
            <li class="header__nav-item">
                <form action="/logout" method="post" class="logout">
                    @csrf
                    <button class="nav__button">ログアウト</button>
                </form>
            </li>
            <li class="header__nav-item">
                <a href="#" class="header__nav-link">マイページ</a>
            </li>
        @else
            <li class="header__nav-item">
                <a href="{{ route('login') }}" class="header__nav-link">ログイン</a>
            </li>
            <li class="header__nav-item">
                <a href="{{ route('register') }}" class="header__nav-link">会員登録</a>
            </li>
        @endif
        <li class="header__nav-item">
            <a href="#" class="header__nav-link--sell">出品</a>
        </li>
    </ul>
</nav>
@endsection

@section('content')

@endsection