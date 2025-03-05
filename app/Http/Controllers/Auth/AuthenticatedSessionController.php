<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //ユーザー認証
        $request->authenticate();
        //セッションを再生成
        $request->session()->regenerate();


        //ログイン後のリダイレクト先
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::logout();  // ログアウトさせる
        $request->session()->invalidate();  // セッションを無効化
        $request->session()->regenerateToken();  // CSRFトークンを再生成
        return redirect('/login');  // ログアウト後のリダイレクト先
    }

}
