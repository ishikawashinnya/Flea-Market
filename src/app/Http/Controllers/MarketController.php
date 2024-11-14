<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Sold_item;
use App\Models\Profile;
use App\Models\Category_item;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
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

        return view('toppage', compact('items', 'likes', 'soldItems'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
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

        return view ('mypage', compact('user', 'items', 'soldItems', 'profile', 'profileImgUrl'), ['showSearchForm' => true, 'showToppageButton' => true, 'showSellpageButton' => true]);
    }

    public function profile() {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view ('profile', compact('user', 'profile'), ['showMypageButton' => true, 'showToppageButton' => true]);
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

    public function editAddress(Request $request) {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();
        $item_id = $request->query('item_id');

        return view ('edit_address', compact('user', 'profile', 'item_id'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function updateAddress(AddressRequest $request) {
        $user = Auth::user();

        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->postcode = $request->postcode;
        $profile->address = $request->address;
        $profile->building = $request->building;

        $profile->save();

        $item_id = $request->input('item_id');

        return redirect()->route('edit.address')->with('success', '配送先が更新されました');
    }

    public function detail($item_id) {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $likes = Like::where('item_id', $item->id)->count();
        $comments = Comment::where('item_id', $item->id)->get();
        $category_items = $item->categories;
        $userLikes = $user ? Like::where('user_id', $user->id)->pluck('item_id')->toArray() : [];

        return view('item_detail', compact('item', 'user', 'likes', 'comments', 'category_items', 'userLikes'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    public function sell() {
        $user = Auth::user();
        $item = Item::all();
        $categories = Category::all();
        $conditions = Condition::all();
        return view ('sellpage', compact('user', 'item', 'categories', 'conditions'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function storeSell(Request $request) {
        $item = new Item();
        $item->user_id = Auth::id();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->description = $request->input('description');
        $item->condition_id = $request->input('condition_id');

        if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('item_images', 'public');
            $item->img_url = str_replace('item_images/', '', $img_url);
        }

        $item->save();

        $category_item = new Category_item();
        $category_item->item_id = $item->id;
        $category_item->category_id = $request->input('category_id');

        $category_item->save();

        return redirect()->back()->with('success', '出品が完了しました');
    }

    public function buy($item_id) {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);
        $profile = auth()->user()->profile;

        return view ('buypage', compact('user', 'item', 'profile'), ['showSearchForm' => true, 'showMypageButton' => true, 'showSellpageButton' => true]);
    }
}
