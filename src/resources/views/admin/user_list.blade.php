@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="list__header">
        <div class="list__ttl">
            <h2>ユーザー一覧</h2>
        </div>
        <div class="alert">
            @if(session('success'))
                <div class="alert__success">
                    <p class="alert__message">{{ session('success')}}</p> 
                </div>
            @endif
        </div>
    </div>

    <div class="list__main">
        <table class="list__table">
            <tr class="title__row">
                <th class="table__label">ユーザーID</th>
                <th class="table__label">名前</th>
                <th class="table__label">メールアドレス</th>
            </tr>

            @foreach ($users as $user)
                <tr class="value__row">
                    <td class="value__list">
                        {{ $user->id }}
                    </td>
                    <td class="value__list">
                        {{ $user->name }}
                    </td>
                    <td class="value__list">
                        {{ $user->email }}
                    </td>
                    <td>
                        <form action="{{ route('destroy.user', ['user_id' => $user->id]) }}" method="POST" class="delete__form">
                            @csrf
                            @method('DELETE')
                            <button class="delete__btn" type="submit" onclick="return confirm('ユーザーを削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="pagination">
        {{ $users->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection