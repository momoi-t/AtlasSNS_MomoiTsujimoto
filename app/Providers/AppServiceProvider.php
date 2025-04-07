<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //ログインユーザのアイコンパス設定
        View::composer('*', function ($view) {
        $user = Auth::user();

        $authIconPath = null;
        if ($user) {
            $authIconPath = $user->icon_image === 'icon1.png'
                ? asset('images/icon1.png')
                : asset('/' . $user->icon_image);
        }

        $view->with('authIconPath', $authIconPath);
    });
    }
}
