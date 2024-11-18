@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/seller_item.css') }}" />
@endsection

@section('content')
<div class="seller__item-content">
    <div class="content__header">
        <div class="user__profile">
            <div class="profile__img">
                <img src="{{ $profileImgUrl }}" alt="画像">
            </div>
            <div class="profile__name">
                <p>{{ $sellerUser->name }}の出品商品</p>
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
                        <div class="item__like">
                            @if (in_array($item->id, $likes))
                                <form action="{{ route('destroy.like', $item->id) }}" method="POST" class="item__like-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="like__form-btn">
                                        <img src="{{ asset('icon/heart_color.svg') }}" alt="お気に入り解除">
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('store.like') }}" method="POST" class="item__like-form">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="like__form-btn">
                                        <img src="{{ asset('icon/heart.svg') }}" alt="お気に入り登録">
                                    </button>
                                </form>
                            @endif
                        </div>
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