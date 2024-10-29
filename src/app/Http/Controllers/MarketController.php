<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
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

        if ($request->has('tab') && $request->tab === 'mylist') {
            if ($user) {
                $likes = Like::where('user_id', $user->id)->pluck('item_id')->toArray();
                $items = Item::where('id', $likes)->get();
            } else {
                $items = collect();
            }
        }

        return view('top_page', compact('items', 'likes'));
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
}
