<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Sold_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->input('word');
        $user = Auth::user();

        if ($keyword) {
            $items = Item::where('name', 'LIKE', '%' . $keyword . '%')->get();
        } else {
            $items = Item::all();
        }

        $likes = $user ? $user->likes()->pluck('item_id')->toArray() : [];

        $soldItems = Sold_item::pluck('item_id')->toArray();

        if ($request->has('tab') && $request->tab === 'mylist') {
            if ($user) {
                $likes = Like::where('user_id', $user->id)->pluck('item_id')->toArray();
                $items = Item::whereIn('id', $likes)->get();
            } else {
                $items = collect();
            }
        }

        return view('top_page', compact('items', 'likes', 'soldItems'));
    }

    public function likeCreate(Request $request) {
        $user = Auth::user();

        $existingLike = Like::where('item_id', $request->item_id)->where('user_id', $user->id)->first();

        if ($existingLike) {
            return back();
        }

        $like = new Like;
        $like->item_id = $request->item_id;
        $like->user_id = $user->id;
        $like->save();

        return back();
    }

    public function likeDestroy(Request $request, $id) {
        $like = Like::where('item_id', $id)->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        }

        return back();
    }

    public function mypage(Request $request) {
        $keyword = $request->input('word');
        $user = Auth::user();

        if ($request->has('tab') && $request->tab === 'buys') {
            if ($user) {
                $buys = Sold_item::where('user_id', $user->id)->pluck('item_id')->toArray();
                if ($keyword) {
                    $items = Item::whereIn('id', $buys)->where('name', 'LIKE', '%' . $kyeword . '%')->get();
                } else {
                    $items = Item::whereIn('id', $buys)->get();
                }
            } else {
                $items = collect();
            }
        } else {
            if ($keyword) {
                $items = Item::where('user_id', $user->id)->where('name', 'LIKE', '%' . $kyeword . '%')->get();
            } else {
                $items = Item::where('user_id', $user->id)->get();
            }
        }

        $soldItems = Sold_item::pluck('item_id')->toArray();

        $profileImgUrl = $user->profile->img_url ?? asset('icon/face.svg');

        return view ('my_page', compact('user', 'items', 'soldItems', 'profileImgUrl'));
    }
}
