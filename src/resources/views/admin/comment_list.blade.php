@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/comment_list.css') }}" />
@endsection

@section('content')
<div class="list__content">
    <div class="list__header">
        <div class="list__ttl">
            <h2>コメント一覧</h2>
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
                <th class="comment__user-label">ユーザー名</th>
                <th class="item__name-label">投稿商品名</th>
                <th class="comment__list-label">コメント</th>
            </tr>

            @foreach ($comments as $comment)
                <tr class="comment__row">
                    <td class="comment__user">
                        {{ $comment->user->name }}
                    </td>
                    <td class="item__name">
                        {{ $comment->item->name }}
                    </td>
                    <td class="comment__list">
                        <p class="user__comment">{{ $comment->comment }}</p>
                    </td>
                    <td>
                        <form action="{{ route('destroy.comment', ['comment_id' => $comment->id]) }}" method="POST" class="delete__form">
                            @csrf
                            @method('DELETE')
                            <button class="delete__btn" type="submit" onclick="return confirm('コメントを削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="pagination">
        {{ $comments->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection