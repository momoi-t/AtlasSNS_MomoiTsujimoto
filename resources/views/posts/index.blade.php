<x-login-layout>

        <!-- 投稿フォーム -->
        <div class="form-container">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
              @if(Auth::check())
                <img src="{{ asset('images/' . Auth::user()->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
              @endif
                <textarea id="content" name="post" rows="4" required placeholder="投稿内容を入力してください。"minlength="1" maxlength="150"></textarea>

            <button type="submit">
                <img src="{{ asset('images/post.png')}}" alt="投稿する">
            </button>
        </form>
        </div>

        <!-- 投稿一覧 -->
        <div class="posts-container">
          @foreach($posts as $post)
            <div class="post">
                <div class="post-header">
                    <img src="{{ asset('images/' . $post->user->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
                    <span class="username">{{ $post->user->username }}</span>
                    <span class="post-time">{{ $post->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <p class="post-content">{!! nl2br(e($post->post)) !!}</p>

        <!-- ボタンエリア -->
        @if(Auth::id() === $post->user_id)
          <!-- 編集ボタン -->
            <a href="{{ route('posts.edit', $post->id) }}" class="action-link">
            <img src="{{ asset('images/edit.png') }}" alt="編集" class="action-icon">
            </a>
          <!-- 削除ボタン -->
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirm('本当に削除しますか？')" style="background: none; border: none;">
                <img src="{{ asset('images/trash.png') }}" alt="削除" class="action-icon">
                </button>
        @endif
            </div>
          @endforeach
        </div>

</x-login-layout>
