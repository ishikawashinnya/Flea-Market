@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
<div class="mypage__content">
    <div class="content__header">
        <div class="header__profile">
            <div class="user__profile">
                <div class="profile__img">
                    <img src="{{ $profile->img_url ? asset('storage/' . $profile->img_url) : asset('icon/face.svg') }}" alt="画像">
                </div>
                <div class="profile__name">
                    <p>{{ $user->name }}</p>
                </div>
            </div>
            <div class="profile__edit">
                <a href="{{ route('profile') }}" class="profile__edit-link">プロフィールを編集</a>
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
                    <a href="{{ route('detail', $item->id) }}" class="detail__link">
                        @if (filter_var($item->img_url, FILTER_VALIDATE_URL))
                           <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
                        @else
                            <img src="{{ asset('storage/item_images/' . $item->img_url) }}" alt="{{ $item->name }}" >
                        @endif
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
                    <a href="{{ route('detail', $item->id) }}" class="detail__link">
                        <p>{{ $item->name }}</p>
                    </a>
                </div>
            </div>
        @endforeach
    </div> 
</div>
@endsection