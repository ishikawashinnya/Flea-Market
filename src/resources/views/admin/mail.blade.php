@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/mail.css') }}">
@endsection

@section('content')
<div class="mail__content">
    <div class="content__header">
        <div class="content__header-ttl">
            <h2>メール作成</h2>
        </div>  
        @if(session('success'))
            <div class="alert__success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    
    <div class="content__main">
        <div class="content__wrap">
            <form action="{{ route('send.mail') }}" method="post" class="mail__form">
                @csrf
                <div class="mail__form-groupe">
                    <label for="destination" class="form__label">宛先</label>
                    <div class="mail__destination">
                        <select name="destination" id="destination"  class="destination__select">
                            <option value="user" selected>ユーザー</option>
                        </select>
                    </div>
                </div>

                <div class="mail__form-groupe">
                    <label for="textarea" class="form__label">本文</label>
                    <div class="mail__textarea">
                        <textarea id="textarea" class="textarea" name="message" rows="15" required></textarea>
                    </div>
                </div>

                <div class="form__button">
                    <div class="form__link">
                        <a href="{{ route('admin') }}" class="back__button">戻る</a>
                    </div>
                    <button type="submit" class="form__button-btn">メール送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection