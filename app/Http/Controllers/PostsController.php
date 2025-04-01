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

        //各投稿のユーザのiconPath
        foreach ($posts as $post) {
        $post->user->iconPath = $post->user->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('/' . $post->user->icon_image);
        }

        // ログインユーザーのiconPath
        $authIconPath = auth()->check()
        ? (auth()->user()->icon_image === 'icon1.png'
            ? asset('images/icon1.png')
            : asset('storage/' . auth()->user()->icon_image))
        : null;

        return view('posts.index', compact('posts','authIconPath'));
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
        return redirect()->route('posts.index');
    }

    //投稿編集
        //①データ取得
        public function edit(Post $post)
        {
        //認可チェック
        if (Auth::id() !== $post->user_id) {
            return response()->json(['error' => '編集権限がありません。'], 403);
        }
    //JSONで返す（モーダル用)
    return response()->json($post);

    }
    //②編集処理
    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', '編集権限がありません。');
        }
        $validated = $request->validate([
            'post' => 'required|string|min:1|max:150',
        ], [
            'post.required' => '投稿内容は必須です。',
            'post.min' => '1文字以上入力してください。',
            'post.max' => '150文字以内で入力してください。',
        ]);

        // 投稿を更新
        $post->update(['post' => $validated['post']]);

        return redirect()->route('posts.index')->with('success', '投稿を編集しました。');
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
