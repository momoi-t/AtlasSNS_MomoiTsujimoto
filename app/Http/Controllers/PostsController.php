<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    //ミドルウェア適用
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        // 投稿を新しい順に取得
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return view('posts.index', compact('posts'));
    }

    //投稿
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'post' => 'required|string|min:1|max:150',  // 1文字以上150文字以内
        ],[
            'post.required' => '投稿内容は必須です。',
            'post.min' => '1文字以上入力してください。',
            'post.max' => '150文字以内で入力してください。',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('top')->with('error', 'ログインが必要です');
        }

        // 投稿を作成
        Post::create([
            'user_id' => $userId,
            'post' => $validated['post'],
        ]);

        // 投稿後にリダイレクト
        return redirect()->route('top');
    }


}
