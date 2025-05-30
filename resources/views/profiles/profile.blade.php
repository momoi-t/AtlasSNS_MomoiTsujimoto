<x-login-layout>

<!-- ユーザープロフィール情報 -->
<div class="profile-container">
    <div class="user">
        <img src="{{ $user->iconPath }}" alt="ユーザーアイコン" class="user-icon">
        <div class="profile-details">
          <div class="profile-username"><strong>ユーザー名</strong><p class="username-details">{{ $user->username }}</p>
          </div>
          <div class="profile-bio"><strong>自己紹介</strong><p class="bio-details">{{ $user->bio }}</p>
          </div>
        </div>

        <!-- フォロー/フォロー解除ボタン -->
        <div class="follow-button profile">
          @if(Auth::id() !== $user->id)
            @if(Auth::user()->isFollowing($user->id))
                <form action="{{ route('unfollow', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">フォロー解除</button>
                </form>
            @else
                <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">フォローする</button>
                </form>
            @endif
          @endif
        </div>
    </div>
</div>

<!-- 投稿一覧（followListと同じ構成） -->
<div class="posts-container">
  @foreach($posts as $post)
    <div class="post">
      <div class="post-header">
        <a href="{{ route('profile', ['user' => $post->user->id]) }}">
        <img src="{{ $post->user->iconPath }}" alt="ユーザーアイコン" class="user-icon">
        </a>
        <span class="username">{{ $post->user->username }}</span>
        <span class="post-time">{{ $post->created_at->format('Y-m-d H:i') }}</span>
      </div>
      <p class="post-content">{!! nl2br(e($post->post)) !!}</p>
      <div class="post-button">
        @if(Auth::id() === $post->user_id)
          <!-- 編集 -->
          <button class="edit-btn"
            data-post-id="{{ $post->id }}"
            data-post-content="{{ $post->post }}" >
          </button>
          <!-- 削除 -->
          <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
            @csrf
            @method('DELETE')
              <button class="delete-btn" type="submit"  onclick="return confirm('本当に削除しますか？')">
              </button>
          </form>
        @endif
      </div>
    </div>
  @endforeach
</div>


</x-login-layout>
