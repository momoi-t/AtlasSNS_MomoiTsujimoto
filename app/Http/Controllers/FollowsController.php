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

    // フォローしているユーザーのIDを取得
        $followingIds = $user->followings()->pluck('followed_id');

    // フォローしているユーザーの投稿のみ取得（最新順）
        $posts = \App\Models\Post::whereIn('user_id', $followingIds)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('follows.followList', compact('followingUsers', 'posts'));
    }


    public function followerList(){
        $user = Auth::user();

    // フォロワーの情報を取得
        $followedUsers = $user->followers()
        ->orderBy('created_at', 'desc')
        ->get();

    // フォロワーのIDを取得
        $followedIds = $user->followers()->pluck('following_id');

    // フォロワーの投稿のみ取得（最新順）
        $posts = \App\Models\Post::whereIn('user_id', $followedIds)
        ->orderBy('created_at', 'desc')
        ->get();

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
