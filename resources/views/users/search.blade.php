<x-login-layout>
<!-- 検索フォーム -->
<div class="form-container">
    <form action="{{ route('search') }}" method="GET" class="search-form">
        <input type="text" name="keyword" placeholder="ユーザー名" value="{{ old('keyword', $keyword ?? '') }}" class="keyword-area">
        <button type="submit">
            <img src="{{ asset('images/search.png')}}" alt="検索">
        </button>
    </form>

    <!-- 検索ワードを表示 -->
    @if(!empty($keyword))
        <div class="search-word">検索ワード：{{ $keyword }}</div>
    @endif
</div>

<!-- ユーザ一覧（検索結果） -->
<div class="users-container">
    @foreach($users as $user)
        <div class="user">
            <img src="{{ asset('images/' . $user->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
            <span class="username">{{ $user->username }}</span>

            <div class="follow-button">
            @if(Auth::id()  !== $user->id)
              @if(Auth::user()->isFollowing($user->id))
              <!-- フォロー解除ボタン -->
                <form action="{{ route('unfollow', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">フォロー解除</button>
                </form>
                @else
                <!-- フォローボタン-->
              <form action="{{ route('follow', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">フォローする</button>
                </form>
              @endif
            @endif
            </div>
        </div>
    @endforeach
</div>

</x-login-layout>
