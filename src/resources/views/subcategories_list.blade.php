@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}" />
@endsection

@section('content')
<div class="search__content">
    <div class="content__ttl">
        <h2>{{ $category->name }}</h2>
    </div>
    <div class="content__main">
        <ul class="search__list">
            <li class="search__list-item">
                <a href="{{ route('category.all', ['category_id' => $category->id]) }}" class="search__link">
                    すべて
                </a>
            </li>
            @foreach($subcategories as $subcategory)
                <li class="search__list-item">
                    <a href="{{ route('category.search.result', ['category_id' => $category->id, 'subcategory_id' => $subcategory->id]) }}" class="search__link">
                        {{ $subcategory->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection