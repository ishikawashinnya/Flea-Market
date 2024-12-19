@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/search_result.css') }}" />
@endsection

@section('content')
<div class="result__content">
    <div class="content__header">
        <div class="header__ttl">
            @if (isset($subcategory) && $subcategory)
                <h2>{{ $subcategory->name }} の検索結果</h2>
            @else
                <h2>{{ $category->name }} の検索結果</h2>
            @endif
        </div>
    </div>
    <div class="content__main">
        @foreach($items as $item)
            <div class="card">
                <div class="item__img">
                    <a href="{{ route('detail', $item->id) }}" class="detail__link">
                        <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}">
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