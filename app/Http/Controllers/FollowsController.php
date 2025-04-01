<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{
    //
    public function followList(){
        $user = Auth::user();

    // フォローしているユーザーの情報を取得
        $followingUsers = $user->followings()
        ->orderBy('created_at', 'desc')
        ->get();

    // 各フォローしているユーザーのアイコンパスを設定
    foreach ($followingUsers as $followingUser) {
        $followingUser->iconPath = $followingUser->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('/' . $followingUser->icon_image);
    }

    // フォローしているユーザーのIDを取得
        $followingIds = $user->followings()->pluck('followed_id');

    // フォローしているユーザーの投稿のみ取得（最新順）
        $posts = \App\Models\Post::whereIn('user_id', $followingIds)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get();

        // 各投稿のユーザーのアイコンパスを設定
        foreach ($posts as $post) {
            $post->user->iconPath = $post->user->icon_image === 'icon1.png'
                ? asset('images/icon1.png')
                : asset('/' . $post->user->icon_image);
        }

        return view('follows.followList', compact('followingUsers', 'posts'));
    }


    public function followerList(){
        $user = Auth::user();

    // フォロワーの情報を取得
        $followedUsers = $user->followers()
        ->orderBy('created_at', 'desc')
        ->get();

    // 各フォロワーのアイコンパスを設定
    foreach ($followedUsers as $followedUser) {
        $followedUser->iconPath = $followedUser->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('/' . $followedUser->icon_image);
    }

    // フォロワーのIDを取得
        $followedIds = $user->followers()->pluck('following_id');

    // フォロワーの投稿のみ取得（最新順）
        $posts = \App\Models\Post::whereIn('user_id', $followedIds)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get();

    // 各投稿のユーザーのアイコンパスを設定
        foreach ($posts as $post) {
            $post->user->iconPath = $post->user->icon_image === 'icon1.png'
                ? asset('images/icon1.png')
                : asset('/' . $post->user->icon_image);
        }

        return view('follows.followerList', compact('followedUsers', 'posts'));
    }

    /**フォロー機能 */
    public function follow($id)
    {
        $user = Auth::user();

        // すでにフォローしていないかチェック
        if (!$user->isFollowing($id)) {
            Follow::create([
                'following_id' => $user->id,
                'followed_id' => $id,
            ]);
        }

        return back();
    }

    /**フォロー解除機能 */
    public function unfollow($id)
    {
        $user = Auth::user();

        Follow::where('following_id', $user->id)
            ->where('followed_id', $id)
            ->delete();

        return back();
    }

}
