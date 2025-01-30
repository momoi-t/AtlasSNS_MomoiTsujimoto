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

    //バリデーション
    //UserName　　入力必須・2文字以上,12文字以内
    //MailAdress　入力必須・5文字以上,40文字以内・登録済み使用不可・メールアドレスの形式
    //Password	　入力必須・英数字のみ・8文字以上,20文字以内
    //PasswordConfirm	Password入力欄と一致しているか

    public function store(Request $request): RedirectResponse
    {
        User::create([
            'username' => $request->username,
            'mail' => $request->mail,
            'password' => Hash::make($request->password),
        ]);

        return redirect('added');
    }

    public function added(): View
    {
        return view('auth.added');
    }
}
