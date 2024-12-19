@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}" />
@endsection

@section('content')
<div class="search__content">
    <div class="content__ttl">
        <h2><h2>カテゴリー一覧</h2></h2>
    </div>
    <ul class="search__list">
        @foreach($categories as $category)
            <li class="search__list-item">
                <a href="{{ route('subcategories.list', $category->id) }}" class="search__link">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection