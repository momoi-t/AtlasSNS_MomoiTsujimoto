<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function index(Request $request)
    {
        $keyword = $request->input('keyword'); // 検索キーワード取得
        $authUserId = Auth::id(); // ログイン中のユーザーのIDを取得

        if (!empty($keyword)) {
            // 検索キーワードに該当するユーザーを取得
            $users = User::where('username', 'like', "%{$keyword}%")
                ->where('id','<>',$authUserId) //自分を除外
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // 検索キーワードがない場合全ユーザを取得（自分を除外）
            $users = User::where('id','<>',$authUserId)
            ->orderBy('created_at', 'desc')
            ->get();
        }

        // 各ユーザーのアイコンパスを設定
        foreach ($users as $user) {
            $user->iconPath = $user->icon_image === 'icon1.png'
                ? asset('images/icon1.png')
                : asset('/' . $user->icon_image);
    }

        // ログインユーザーのiconPath
        $authIconPath = $user->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('/' . $user->icon_image);


        return view('users.search', compact('users', 'keyword'));
    }
}
