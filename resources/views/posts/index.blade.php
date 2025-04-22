<x-login-layout>

<!-- 投稿フォーム -->
<div class="form-container">
  <form action="{{ route('posts.store') }}" method="POST" class="post-form">
    @csrf
    @if(Auth::check())
      <img src="{{ $authIconPath }}" alt="ユーザーアイコン" class="user-icon">
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
        <img src="{{ $post->user->iconPath }}" alt="ユーザーアイコン" class="user-icon">

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
          <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-btn">
            @csrf
            @method('DELETE')
              <button type="submit"  onclick="return confirm('本当に削除しますか？')">
              </button>
          </form>
        @endif
      </div>

    </div>
  @endforeach
</div>

<!-- 投稿編集モーダル -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <textarea name="post" id="editContent" rows="4" required minlength="1" maxlength="150"></textarea>
            <button type="submit">更新</button>
        </form>
    </div>
</div>

</x-login-layout>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editModal');
    const closeBtn = document.querySelector('.close');
    const editBtns = document.querySelectorAll('.edit-btn');
    const editForm = document.getElementById('editForm');
    const editContent = document.getElementById('editContent');

    editBtns.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            const postContent = this.getAttribute('data-post-content');

            editContent.value = postContent;
            editForm.action = `/posts/${postId}`;

            modal.style.display = 'block';
        });
    });

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
