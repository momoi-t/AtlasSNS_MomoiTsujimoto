<x-login-layout>
        <!-- 投稿フォーム -->
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

        <!-- 投稿一覧 -->
        <div class="posts">
          @foreach($posts as $post)
            <div class="post">
                <div class="post-header">
                    <img src="{{ asset('images/' . $post->user->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
                    <span class="username">{{ $post->user->username }}</span>
                </div>
                <p class="post-content">{!! nl2br(e($post->post)) !!}</p>
                <span class="post-time">{{ $post->created_at->format('Y-m-d H:i') }}</span>
            </div>
          @endforeach
        </div>

</x-login-layout>
