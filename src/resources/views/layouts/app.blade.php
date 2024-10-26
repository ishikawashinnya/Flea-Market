<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header__left">
            <div class="header__logo">
                <a href="{{ route('home') }}" class="header__link">
                    <img src="{{ asset('icon/logo.svg') }}" alt="COACHTECH">
                </a>
            </div>
        </div>
        @yield('header')
    </header>

    <main>
        @yield('content')
    </main>  
</body>
</html>