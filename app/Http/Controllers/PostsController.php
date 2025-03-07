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

    //投稿を編集
    public function edit(Post $post)
    {

        //認可チェック（ログインユーザー以外が編集できないようにする）
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', '編集権限がありません。');
    }

    //編集後にリダイレクト
    return view('posts.edit', compact('post'));
}

    //投稿を削除
    public function destroy(Post $post)
    {

        // 認可チェック（ログインユーザー以外が削除できないようにする）
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', '削除権限がありません。');
    }

    // 投稿を削除
    $post->delete();

    return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
}


}
