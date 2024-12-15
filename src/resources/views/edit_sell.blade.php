@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sellpage.css') }}" />
@endsection

@section('content')
<div class="sell__content">
    <div class="content__header">
        <h2>出品情報の変更</h2>
        <div class="alert">
            @if(session('success'))
                <div class="alert__success">
                    <p class="alert__message">{{ session('success')}}</p> 
                </div>
            @endif
        </div>
    </div>

    <div class="content__main">
        <form action="{{ route('update.sell', ['id' => $item->id]) }}" method="post" class="sell__form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="img__field">
                <label for="item__img" class="form__label">
                    商品画像<span class="required">※</span>
                </label>
                <div class="img__preview">
                    <img id="item__img" src="{{ asset($item->img_url) }}" alt="商品画像">
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

            <div class="input__ttl">
                <h3>商品の詳細</h3>
            </div>
            <div class="form__item">
                <label for="category" class="form__label">
                    カテゴリー<span class="required">※</span>
                </label>
                <select name="category_id" id="category" class="form__select">
                    <option value="" disabled selected></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(in_array($category->id, $itemCategories)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('category')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__item" id="subcategory__container">
                <label for="subcategory" class="form__label">詳細カテゴリー</label>
                <select name="subcategory_id" id="subcategory" class="form__select" ">
                    <option value="" disabled {{ old('subcategory_id', $selectedSubcategoryId) ? '' : 'selected' }}>詳細カテゴリーを選択</option>
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $item->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form__item">
                <label for="condition" class="form__label">
                    商品の状態<span class="required">※</span>
                </label>
                <select name="condition_id" id="condition" class="form__select">
                    <option value="" disabled selected></option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ $item->condition_id == $condition->id ? 'selected' : '' }}>{{ $condition->condition }}</option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('condition')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="input__ttl">
                <h3>商品名と説明</h3>
            </div>
            <div class="form__item">
                <label for="name" class="form__label">
                    商品名<span class="required">※</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="form__input">
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form__item">
                <label for="description" class="form__label">
                    商品の説明<span class="required">※</span>
                </label>
                <textarea name="description" id="description" cols="32" rows="8" maxlength="150" class="description__text">{{ old('description', $item->description) }}</textarea>
               
                <div class="form__error">
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="input__ttl">
                <h3>販売価格</h3>
            </div>
            <div class="form__item">
                <label for="price" class="form__label">
                    販売価格<span class="required">※</span>
                </label>
                <div class="price__input">
                    <span class="price__prefix">￥</span>
                    <input type="text" name="price" id="price" value="{{ old('price', $item->price) }}" class="form__price-input">
                </div>
                <div class="form__error">
                    @error('price')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit" onclick="return confirm('商品情報を変更しますか？')">変更する</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/sell.js') }}"></script>
@endsection