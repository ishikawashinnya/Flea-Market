@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
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
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder = "ユーザー名">
                <div class="form__error">
                    @error('name')
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
    </div>
</div>

<script src="{{ asset('js/profile.js') }}"></script>
@endsection
