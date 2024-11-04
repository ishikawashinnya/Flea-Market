<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Sold_item;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function storeLike(Request $request) {
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

    public function destroyLike(Request $request, $id) {
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
                    $items = Item::whereIn('id', $buys)->where('name', 'LIKE', '%' . $keyword . '%')->get();
                } else {
                    $items = Item::whereIn('id', $buys)->get();
                }
            } else {
                $items = collect();
            }
        } else {
            if ($keyword) {
                $items = Item::where('user_id', $user->id)->where('name', 'LIKE', '%' . $keyword . '%')->get();
            } else {
                $items = Item::where('user_id', $user->id)->get();
            }
        }

        $soldItems = Sold_item::pluck('item_id')->toArray();

        $profile = $user->profile ?? new Profile();
        $profileImgUrl = $profile->img_url ?? asset('icon/face.svg');

        return view ('my_page', compact('user', 'items', 'soldItems', 'profile', 'profileImgUrl'));
    }

    public function profile() {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view ('profile', compact('user', 'profile'));
    }

    public function updateProfile(ProfileRequest $request) {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->postcode = $request->postcode;
        $profile->address = $request->address;
        $profile->building = $request->building;

        if ($request->hasFile('img_url')) {
            if ($profile->img_url) {
                Storage::disk('public')->delete($profile->img_url);
            }
            $img_url = $request->file('img_url')->store('profile_imgs', 'public');
            $profile->img_url = $img_url;
        } 

        $profile->save();

        return redirect()->route('profile')->with('success', 'プロフィールが更新されました');
    }
}
