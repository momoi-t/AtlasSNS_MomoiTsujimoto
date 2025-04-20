<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ProfileController extends Controller
{
    //プロフィールページ
    public function profile(User $user){
        // 投稿一覧（新しい順）
        $posts = $user->posts()->latest()->get();

        // 対象ユーザーのアイコンパスを設定
        $user->iconPath = $user->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('/' . $user->icon_image);

        // 各投稿のユーザーにもアイコンパスを設定
        foreach ($posts as $post) {
            $postUser = $post->user;
            $postUser->iconPath = $postUser->icon_image === 'icon1.png'
                ? asset('images/icon1.png')
                : asset('/' . $postUser->icon_image);
        }

        // フォロー中かどうかを判定
        $isFollowing = Auth::check() && Auth::user()->isFollowing($user->id);

        return view('profiles.profile',compact('user','posts', 'isFollowing'));
    }

    //プロフィール編集画面
    public function edit(){
        $user = Auth::user();

        // ログインユーザーのiconPath
        $authIconPath = $user->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('/' . $user->icon_image);

        return view('profiles.edit',compact('user','authIconPath'));
    }

    //プロフィール更新処理
    public function update(Request $request){
        $user = auth()->user();

        //バリデーション
        $validated = $request->validate([
        'username' => 'required|string|min:2|max:12',
        'email' => [
            'required',
            'string',
            'email',
            'min:5',
            'max:40',
            function ($attribute, $value, $fail) use ($user) {
                if ($value !== $user->email && User::where('email', $value)->exists()) {
                    $fail('このメールアドレスは既に使用されています。');
                }
            },
        ],
        'new_password' => [
            'required',
            'string',
            'regex:/^[a-zA-Z0-9]+$/',
            'min:8',
            'max:20',
            'confirmed'
        ],
        'bio' => 'nullable|string|max:150',
        'icon_image' => 'nullable|image|mimes:jpg,png,bmp,gif,svg|max:2048', // 画像のみ許可
    ]);

    // ユーザー情報の更新
    $user->username = $validated['username'];
    $user->email = $validated['email'];
    $user->password = Hash::make($request->new_password);

    // アイコン画像の処理
    if ($request->hasFile('icon_image')) {
        // 画像ファイルを保存
        $path = $request->file('icon_image')->store('icons', 'public');

        // ユーザーのアイコン画像をデータベースに保存
        $user->icon_image = 'storage/' . $path;
    }

    $user->bio = $validated['bio'];

    $user->save();

    return redirect()->route('top')->with('success', 'プロフィールを更新しました！');

    }
}
