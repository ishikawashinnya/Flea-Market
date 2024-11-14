<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
</head>
<body>
    <header>
        <div class="header__logo">
            <a href="{{ route('home') }}" class="header__link">
                <img src="{{ asset('icon/logo.svg') }}" alt="COACHTECH">
            </a>
        </div>
    </header>
    
    <main>
        <div class="profile__content">
            <div class="content__header">
                <h2>住所の変更</h2>
                <div class="profile__alert">
                    @if(session('success'))
                        <div class="alert__success">
                            <p class="alert__message">{{ session('success')}}</p> 
                        </div>
                    @endif
                </div>
            </div>

            <div class="content__main">
                <form action="{{ route('update.address') }}" method="post" class="profile__form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="item_id" value="{{ $item_id }}">

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
    </main>
</body>
</html>