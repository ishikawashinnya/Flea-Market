@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/admin_mypage.css') }}" />
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__header">
        <h2 class="header__ttl">管理者専用画面</h2>
    </div>

    <div class="admin__main">
        <div class="admin__link">
            <a href="{{ route('userlist') }}" class="admin__link-item">
                <p>ユーザー一覧</p>
            </a>
        </div>
        <div class="admin__link">
            <a href="{{ route('commentlist') }}" class="admin__link-item">
                <p>コメント一覧</p>
            </a>
        </div>
        <div class="admin__link">
            <a href="{{ route('mailform') }}" class="admin__link-item">
                <p>メールフォーム</p>
            </a>
        </div>                 
    </div>
</div>
@endsection