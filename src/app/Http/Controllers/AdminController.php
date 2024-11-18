<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{
    public function getUsers()
    {
        $users = User::paginate(10);

        return view('admin.user_list', compact('users'),['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function destroyUser($user_id) {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->back()->with('success', 'ユーザーが削除されました');
    }
}
