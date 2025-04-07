<x-login-layout>

<!-- ユーザープロフィール情報 -->
<div class="profile-container">
    <div class="user">
        <img src="{{ $user->iconPath }}" alt="ユーザーアイコン" class="user-icon">
        <div class="profile-details">
          <p class="profile-username">{{ $user->username }}</p>
          <p class="profile-bio">{{ $user->bio }}</p>
        </div>

        <!-- フォロー/フォロー解除ボタン -->
        <div class="follow-button">
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
            data-post-content="{{ $post->post }}" style="background: none; border: none;">
            <img src="{{ asset('images/edit.png') }}" alt="編集" class="action-icon">
          </button>
          <!-- 削除 -->
          <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-btn">
            @csrf
            @method('DELETE')
              <button type="submit"  onclick="return confirm('本当に削除しますか？')" style="background: none; border: none;">
                <img src="{{ asset('images/trash.png') }}" alt="削除" class="action-icon">
              </button>
          </form>
        @endif
      </div>
    </div>
  @endforeach
</div>


</x-login-layout>
