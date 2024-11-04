@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('header')
<div class="header__right">
    <form action="" method="GET" class="header__search">
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
                <a href="{{ route('mypage') }}" class="header__nav-link">マイページ</a>
            </li>
            <li class="header__nav-item--sell">
                <a href="#" class="header__nav-link--sell">出品</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="profile__content">
    <div class="content__header">
        <h2>プロフィール設定</h2>
        <div class="profile__alert">
            @if(session('success'))
                <div class="alert__success">
                    <p class="alert__message">{{ session('success')}}</p> 
                </div>
            @endif
        </div>
    </div>

    <div class="content__main">
        <form action="{{ route('update.profile') }}" method="post" class="profile__form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="img__field">
                <div class="img__preview">
                    <img id="profile__img" src="{{ $profile->img_url ? asset('storage/' . $profile->img_url) : asset('icon/face.svg') }}" alt="画像">
                </div>
                <div class="img__select">
                    <label for="img" class="img__select-label">画像を選択する</label>
                    <input type="file" name="img_url" accept="image/jpeg, image/png" id="img" style="display: none;">
                </div>
            </div>
            <div class="form__error">
                    @error('img_url')
                        {{ $message }}
                    @enderror
                </div>

            <div class="form__input">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" >
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__input">
                <label for="postcode">郵便番号</label>
                <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}" >
                <div class="form__error">
                    @error('postcode')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__input">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address', $profile->address ?? '') }}" >
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__input">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building', $profile->building ?? '') }}" >
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
    </div>
</div>

<script src="{{ asset('js/profile.js') }}"></script>
@endsection
