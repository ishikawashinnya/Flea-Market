<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
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
        <div class="header__right">
            <form action="{{ route('keyword.search') }}" method="GET" class="header__search">
                @csrf
                @if (!empty($showSearchForm) && $showSearchForm)
                    <div class="text__search">
                        <input type="text" name="word" class="text__search-input" placeholder="なにをお探しですか？" value="{{ request('word') }}">
                    </div>
                    <div class="category__search" id="category__search">
                        <a href="{{ route('categories.list') }}" class="category__search-link">カテゴリーからさがす</a>
                    </div>
                @endif
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
                        @if (Auth::user()->hasRole('admin'))
                            <li class="header__nav-item">
                                <a href="{{ route('admin') }}" class="header__nav-link">管理画面</a>
                            </li>
                        @else
                            @if (!empty($showMypageButton) && $showMypageButton)
                                <li class="header__nav-item">
                                    <a href="{{ route('mypage') }}" class="header__nav-link">マイページ</a>
                                </li>
                            @endif
                        @endif
                        @if (!empty($showToppageButton) && $showToppageButton)
                            <li class="header__nav-item">
                                <a href="{{ route('home') }}" class="header__nav-link">トップページ</a>
                            </li>
                        @endif
                    @else
                        @if (!empty($showAuthButton) && $showAuthButton)
                            <li class="header__nav-item">
                                <a href="{{ route('login') }}" class="header__nav-link">ログイン</a>
                            </li>
                            <li class="header__nav-item">
                                <a href="{{ route('register') }}" class="header__nav-link">会員登録</a>
                            </li>
                        @endif
                    @endif
                    @if (!empty($showSellpageButton) && $showSellpageButton)
                        <li class="header__nav-item--sell">
                            <a href="{{ route('sell') }}" class="header__nav-link--sell">出品</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        @yield('header')
    </header>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/common.js') }}"></script>
    @yield('js')
</body>
</html>