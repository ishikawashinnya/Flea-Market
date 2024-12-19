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
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\SellRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MarketController extends Controller
{
    //トップページ画面
    public function index(Request $request) {
        $keyword = $request->input('word');
        $user = Auth::user();
        $items = Item::all();
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

    //お気に入り登録・削除機能
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

    public function keywordSearch(Request $request) {
        $keyword = $request->input('word');
        $items = Item::where('name', 'LIKE', "%{$keyword}%")->get();
        $user = Auth::user();
        $likes = $user ? $user->likes()->pluck('item_id')->toArray() : [];
        $soldItems = Sold_item::pluck('item_id')->toArray();
        
        return view('keyword_search_result', compact('items', 'likes', 'soldItems', "keyword"), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    public function categoriesList() {
        $categories = Category::all();

        return view('categories_list', compact('categories'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }
    
    public function subcategoriesList($category_id) {
        $category = Category::findOrFail($category_id);
        $subcategories = $category->subcategories;

        return view('subcategories_list', compact('category', 'subcategories'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    public function categoryAll($category_id) {
        $category = Category::findOrFail($category_id);
        $items = Item::whereHas('categories', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->get();

        $user = Auth::user();
        $likes = $user ? $user->likes()->pluck('item_id')->toArray() : [];
        $soldItems = Sold_item::pluck('item_id')->toArray();
        $subcategory = null;

        return view('category_search_result', compact('category', 'items', 'likes', 'soldItems', 'subcategory'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    public function categorySearchResult($category_id, $subcategory_id = null) {
        $category = Category::findOrFail($category_id);

        if ($subcategory_id) {
            $subcategory = Subcategory::findOrFail($subcategory_id);
            $items = Item::whereHas('categories', function ($query) use ($category_id) {
                $query->where('categories.id', $category_id);
            })->whereHas('subcategories', function ($query) use ($subcategory_id) {
                $query->where('subcategories.id', $subcategory_id);
            })->get();
        } else {
            $subcategory = null;
            
        }

        $user = Auth::user();
        $likes = $user ? $user->likes()->pluck('item_id')->toArray() : [];
        $soldItems = Sold_item::pluck('item_id')->toArray();

        return view('category_search_result', compact('category', 'subcategory', 'items', 'likes', 'soldItems'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    //マイページ画面
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

    //プロフィール編集画面
    public function profile() {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view ('profile', compact('user', 'profile'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    //プロフィール更新機能
    public function updateProfile(ProfileRequest $request) {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->shipping_name = $request->shipping_name;
        $profile->postcode = $request->postcode;
        $profile->address = $request->address;
        $profile->building = $request->building;

        //ローカル時
        /*if ($request->hasFile('img_url')) {
            if ($profile->img_url) {
                Storage::disk('public')->delete($profile->img_url);
            }
            $img_url = $request->file('img_url')->store('profile_imgs', 'public');
            $profile->img_url = 'storage/' . $img_url;
        }*/

        //AWSデプロイ時
        if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('profile_imgs', 's3');
            $profile->img_url = Storage::disk('s3')->url($img_url);
        }

        $profile->save();

        return redirect()->route('profile')->with('success', 'プロフィールが更新されました');
    }

    //配送先住所変更画面
    public function editAddress(Request $request, $item_id) {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();
        $item = Item::findOrFail($item_id);
        $item_id = $request->query('item_id');

        return view ('edit_address', compact('user', 'profile', 'item_id', 'item'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    //配送先住所変更機能
    public function updateAddress(AddressRequest $request) {
        $user = Auth::user();

        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->shipping_name = $request->shipping_name;
        $profile->postcode = $request->postcode;
        $profile->address = $request->address;
        $profile->building = $request->building;

        $profile->save();

        $item_id = $request->input('item_id');

        return redirect()->back()->with('success', '配送先が更新されました');
    }

    //支払い方法選択画面
    public function editPaymentMethod(Request $request, $item_id) {
        $user = Auth::user();
        $profile = $user->profile;

        if (is_null($profile)) {
            return redirect()->route('edit.address', ['item_id' => $item_id])
                ->with('error', '先に配送先情報を登録してください。');
        }

        $item = Item::findOrFail($item_id);
        $item_id = $request->query('item_id');

        return view ('edit_payment_method', compact('user', 'profile', 'item_id', 'item'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    //支払い方法変更機能
    public function updatePaymentMethod(Request $request) {
        $profile = Auth::user()->profile;
        $profile->payment_method = $request->payment_method;
        $profile->save();

        return redirect()->back()->with('success', '支払い方法を変更しました');
    }

    //商品詳細画面
    public function detail($item_id) {
        $item = Item::findOrFail($item_id);
        $user = $item->user;
        $likes = Like::where('item_id', $item->id)->count();
        $comments = Comment::where('item_id', $item->id)->get();
        $category_item = $item->categories->first();
        $subcategory = $item->subcategories->first();
        $userLikes = $user ? Like::where('user_id', $user->id)->pluck('item_id')->toArray() : [];
        $profile = $user->profile ?? new Profile();
        $profileImgUrl = $profile && $profile->img_url ? asset($profile->img_url) : asset('icon/face.svg');
        $sold_item = Sold_item::where('item_id', $item->id)->first();

        return view('item_detail', compact('item', 'user', 'likes', 'comments', 'category_item', 'userLikes', 'profile', 'profileImgUrl', 'sold_item', 'subcategory'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    //出品画面
    public function sell() {
        $user = Auth::user();
        $item = Item::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $conditions = Condition::all();
        return view ('sellpage', compact('user', 'item', 'categories', 'subcategories', 'conditions'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    //出品商品登録機能
    public function storeSell(SellRequest $request) {
        $item = new Item();
        $item->user_id = Auth::id();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->description = $request->input('description');
        $item->condition_id = $request->input('condition_id');

        //ローカル時
        /*if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('item_images', 'public');
            $item->img_url = 'storage/' . $img_url;
        }*/

        //AWSデプロイ時
        if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('item_images', 's3');
            $item->img_url = Storage::disk('s3')->url($img_url);
        }

        $item->save();

        $category_item = new Category_item();
        $category_item->item_id = $item->id;
        $category_item->category_id = $request->input('category_id');
        $category_item->subcategory_id = $request->input('subcategory_id');
        $category_item->save();

        return redirect()->back()->with('success', '出品が完了しました');
    }

    //出品情報更新画面
    public function editSell($id) {
        $item = Item::findOrFail($id);
        $user = Auth::user();
        $categories = Category::all();
        $conditions = Condition::all();
        $itemCategories = $item->categories->pluck('id')->toArray();
        $categoryItem = Category_item::where('item_id', $item->id)->first();
        $selectedSubcategoryId = $categoryItem ? $categoryItem->subcategory_id : null;
        $subcategories = $selectedSubcategoryId ? Subcategory::where('category_id', $itemCategories[0])->get() : collect();

        return view('edit_sell', compact('user', 'item', 'categories', 'conditions', 'itemCategories', 'subcategories', 'selectedSubcategoryId'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    //出品情報更新機能
    public function updateSell(SellRequest $request, $id) {
        $item = Item::findOrFail($id);
        $item->user_id = Auth::id();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->description = $request->input('description');
        $item->condition_id = $request->input('condition_id');

        //ローカル時
        /*if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('item_images', 'public');
            $item->img_url = 'storage/' . $img_url;
        }*/
        
        //AWSデプロイ時
        if ($request->hasFile('img_url')) {
            $img_url = $request->file('img_url')->store('item_images', 's3');
            $item->img_url = Storage::disk('s3')->url($img_url);
        }

        $item->save();

        $category_ids = $request->input('category_id');
        if ($category_ids) {
            $item->categories()->sync($category_ids);
        } else {
            $item->categories()->sync([]);
        }

        $subcategory_id = $request->input('suncategory_id');
        $categoryItem = Category_item::where('item_id', $item->id)->first();

        if($categoryItem) {
            $categoryItem->category_id = $request->input('category_id');
            $categoryItem->subcategory_id = $subcategory_id !== null ? $subcategory_id : null;
            $categoryItem->save();
        } else {
            $categoryItem = new Category_item();
            $categoryItem->item_id = $item->id;
            $categoryItem->category_id = $request->input('category_id');
            $categoryItem->subcategory_id = $subcategory_id !== null ? $subcategory_id : null;
            $categoryItem->save();
        }

        return redirect()->back()->with('success', '出品情報が変更されました');
    }

    public function getSubcategories(Request $request) {
        $categoryId = $request->query('category_id');
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();

        return response()->json([
            'subcategories' => $subcategories
        ]);
    }

    //購入画面
    public function buy($item_id) {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);
        $profile = auth()->user()->profile;

        return view ('buypage', compact('user', 'item', 'profile'), ['showMypageButton' => true, 'showSellpageButton' => true]);
    }

    //コメント画面
    public function comment($item_id) {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $likes = Like::where('item_id', $item->id)->count();
        $comments = Comment::where('item_id', $item->id)->get();
        $userLikes = $user ? Like::where('user_id', $user->id)->pluck('item_id')->toArray() : [];
        $profile = $user->profile ?? new Profile();
        $profileImgUrl = $profile && $profile->img_url ? asset($profile->img_url) : asset('icon/face.svg');

        return view('comment', compact('item', 'user', 'likes', 'comments',  'userLikes', 'profile', 'profileImgUrl'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }

    //コメント登録・削除機能
    public function storeComment(Request $request, $item_id) {
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->item_id = $item_id;
        $comment->comment = $request->input('comment');

        $comment->save();

        return redirect()->back();
    }

    public function destroyComment($comment_id) {
        $user = Auth::user();

        $comment = Comment::where('user_id', $user->id)
                          ->where('id', $comment_id)
                          ->firstOrFail();

        $comment->delete();

        return redirect()->back();
    }

    //出品者の出品商品一覧画面
    public function sellerItem(Request $request, $user_id) {
        $user = Auth::user();
        $sellerUser = User::findOrFail($user_id);
        $items = Item::where('user_id', $user_id)->get();
        $soldItems = Sold_item::pluck('item_id')->toArray();
        $profile = $sellerUser->profile ?? new Profile();
        $profileImgUrl = $profile && $profile->img_url ? asset($profile->img_url) : asset('icon/face.svg');
        $likes = $user ? $user->likes()->pluck('item_id')->toArray() : [];
        $keyword = $request->input('word');

        if ($keyword) {
            $items = Item::where('user_id', $sellerUser->id)->where('name', 'LIKE', '%' . $keyword . '%')->get();
        } else {
            $items = Item::where('user_id', $sellerUser->id)->get();
        }

        return view ('seller_item', compact('user', 'sellerUser', 'likes', 'items', 'soldItems', 'profile', 'profileImgUrl'), ['showSearchForm' => true, 'showMypageButton' => true, 'showAuthButton' => true, 'showSellpageButton' => true]);
    }
}