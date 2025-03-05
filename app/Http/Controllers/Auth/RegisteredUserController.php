<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        //バリデーション定義
        $request->validate([
        'username' => 'required|min:2|max:12',
        'email' => 'required|email|min:5|max:40|unique:users,email',
        'password' => 'required|alpha_num|min:8|max:20',
        'password_confirmation' => 'required|same:password',
        ]);
        //通過したら登録する
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 登録したユーザー名をセッションに保存
        session(['username' => $request->username]);

        return redirect('added');
    }

    public function added(): View
    {
        return view('auth.added');
    }

    //表示した後にセッションデータを削除
    public function registerComplete()
    {
    session()->forget('username');
    return view('register-complete');
}
}
