<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Pagination\Paginator;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.admin_mypage', ['showSearchForm' => true, 'showToppageButton' => true,]);
    }

    public function getUsers() {
        $users = User::paginate(10);

        return view('admin.user_list', compact('users'),['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function destroyUser($user_id) {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->back()->with('success', 'ユーザーが削除されました');
    }

    public function getComments() {
        $comments = Comment::with('item', 'user')->paginate(10);

        return view('admin.comment_list', compact('comments'), ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function destroyComment($comment_id) {
        $comment = Comment::findOrFail($comment_id);
        $comment->delete();

        return redirect()->back()->with('success', 'コメントが削除されました');
    }

    public function mailform() {
        return view('admin.mail', ['showMypageButton' => true, 'showToppageButton' => true]);
    }

    public function sendMail(Request $request){
        $destination = $request->input('destination');
        $message = $request->input('message');

        if ($destination === 'user') {
            $users = User::doesntHave('roles')->get();
        }

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotificationMail($user, $message));
        }

        return redirect()->back()->with('success', 'メールが送信されました');
    }
}
