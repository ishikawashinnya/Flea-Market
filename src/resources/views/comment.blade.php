@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}" />
@endsection

@section('content')
<div class="comment__content">
    <div class="content__left">
        <div class="item__img">
            <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}">
        </div>
    </div>

    <div class="content__right">
        <div class="item__name">
            <p>{{ $item->name }}</p>
        </div>
        <div class="brand__name">
            <p>ブランド名</p>
        </div>
        <div class="item__price">
            <p>&yen;{{ $item->price }}(値段)</p>
        </div>
        <div class="icon">
                @if (in_array($item->id, $userLikes))
                    <form action="{{ route('destroy.like', $item->id) }}" method="POST" class="item__like-form">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="like__form-btn">
                            <img src="{{ asset('icon/star.svg') }}" alt="お気に入り解除">
                            <span class="total__number">{{ $likes }}</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('store.like') }}" method="POST" class="item__like-form">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <button type="submit" class="like__form-btn">
                            <img src="{{ asset('icon/star.svg') }}" alt="お気に入り登録">
                            <span class="total__number">{{ $likes }}</span>
                        </button>
                    </form>
                @endif
            <div class="icon__img">
                <img src="{{ asset('icon/balloon.svg') }}" alt="コメント">
                <span class="total__number">{{ $comments->count() }}</span>
            </div>
        </div>
        <div class="comment__view">
            @foreach ($comments as $comment)
                @if ($comment->user_id === $item->user_id)
                    <div class="seller__comment">
                        <div class="seller__user-profile">
                            <div class="profile__name">
                                <p>{{ $comment->user->name }}</p>
                            </div>
                            <div class="profile__img">
                                <img src="{{ isset($comment->user->profile) && $comment->user->profile->img_url ? asset($comment->user->profile->img_url) : asset('icon/face.svg') }}" alt="画像">
                            </div>
                        </div>
                        <div class="comment__view-area">
                            <p class="user__comment">{{ $comment->comment }}</p>
                            @if ($comment->user_id === Auth::id())
                                <form action="{{ route('destroy.comment', ['comment_id' => $comment->id]) }}" method="POST" class="delete__form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete__btn" type="submit" onclick="return confirm('コメントを削除しますか？')">削除</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="buyer__comment">
                        <div class="buyer__user-profile">
                            <div class="profile__img">
                                <img src="{{ isset($comment->user->profile) && $comment->user->profile->img_url ? asset($comment->user->profile->img_url) : asset('icon/face.svg') }}" alt="画像">
                            </div>
                            <div class="profile__name">
                                <p>{{ $comment->user->name }}</p>
                            </div>
                        </div>
                        <div class="comment__view-area">
                            <p class="user__comment">{{ $comment->comment }}</p>
                            @if ($comment->user_id === Auth::id() || $item->user_id === Auth::id())
                                <form action="{{ route('destroy.comment', ['comment_id' => $comment->id]) }}" method="POST" class="delete__form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete__btn" type="submit" onclick="return confirm('コメントを削除しますか？')">削除</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
       
        <form action="{{ route('store.comment', ['item_id' => $item->id]) }}" method="post" class="comment__form">
            @csrf
            <div class="form__item">
                <label for="comment" class="comment__label">商品へのコメント</label>
            <textarea name="comment" id="comment" rows="6" maxlength="150" class="comment__text">{{ old('comment') }}</textarea>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit" onclick="return confirm('コメントを送信しますか？')">コメントを送信する</button>
            </div>
        </form>
    </div>
</div>
@endsection