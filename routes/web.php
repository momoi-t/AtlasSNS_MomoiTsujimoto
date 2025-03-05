<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\FollowsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


require __DIR__ . '/auth.php';

//ログイン中
Route::middleware('auth')->group(function (){
  //トップページ
  Route::get('top',[PostsController::class,'index'])->name('top');
  //投稿を保存
  Route::post('posts', [PostsController::class,'store'])->name('posts.store');
  //プロフィール
  Route::get('profile',[ProfileController::class,'profile'])->name('profile');
  //検索
  Route::get('search', [UsersController::class, 'index'])->name('search');
  //フォロー・フォロワーリスト
  Route::get('follow-list', [FollowsController::class, 'followList'])->name('follow-list');
  Route::get('follower-list', [FollowsController::class, 'followerList'])->name('follower-list');
  //ログアウト
  Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
