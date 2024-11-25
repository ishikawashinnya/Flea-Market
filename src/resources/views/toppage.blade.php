@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/toppage.css') }}" />
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
                        <p class="item__price">&yen;{{ number_format($item->price) }}</p>                  
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