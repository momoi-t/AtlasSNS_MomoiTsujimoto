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
        return view('profiles.profile',compact('user'));
    }

    //プロフィール編集画面
    public function edit(){
        $user = Auth::user();
        return view('profiles.edit',compact('user'));
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
        'password' => [
            'sometimes',
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

    // パスワードが入力された場合のみ更新
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

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
