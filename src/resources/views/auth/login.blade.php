@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
@endsection

@section('content')
<div class="auth__content">
    <div class="auth__header">
        <h2>ログイン</h2>
    </div>

    <div class="auth__content-form">
        <form action="{{ route('store.login') }}" method="post" class="form">
            @csrf
            <div class="form__input">
                <label for="email" class="form__input-label">メールアドレス</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form__input-area">
            </div>
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>

            <div class="form__input">
                <label for="password" class="form__input-label">パスワード</label>
                <input type="password" name="password" id="password" class="form__input-area">
            </div>
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">ログインする</button>
            </div>
        </form>

        <div class="auth__link">
            <a href="{{ route('register') }}" class="link__button">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection