<x-login-layout>

    <div class="edit-form-container">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- アイコンとユーザー名 -->
            <div class="form-group">
            <img src="{{ asset('images/' . $user->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
            <label for="username">ユーザー名</label>
                <input type="text" name="username" id="username" class="input-area @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required minlength="2" maxlength="12">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- メールアドレス -->
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" class="input-area @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 新しいパスワード -->
            <div class="form-group">
                <label for="new_password">新しいパスワード</label>
                <input type="password" name="new_password" id="new_password" class="input-area @error('new_password') is-invalid @enderror" required minlength="8" maxlength="20" pattern="[A-Za-z0-9]+" placeholder="英数字のみ">
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワード確認 -->
            <div class="form-group">
                <label for="new_password_confirmation">パスワード確認</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="input-area @error('new_password_confirmation') is-invalid @enderror" required minlength="8" maxlength="20" pattern="[A-Za-z0-9]+" placeholder="新しいパスワードと一致">
                @error('new_password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 自己紹介 -->
            <div class="form-group">
                <label for="bio">自己紹介</label>
                <textarea name="bio" id="bio" class="input-area @error('bio') is-invalid @enderror" rows="4" maxlength="150">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 新しいアイコン画像 -->
            <div class="form-group">
                <label for="icon_image">新しいアイコン画像</label>
                <input type="file" name="icon_image" id="icon_image" class="input-area @error('icon_image') is-invalid @enderror" accept="image/*">
                @error('icon_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="profile-edit-btn">
            <button type="submit" class="btn btn-danger">更新</button>
            </div>
        </form>
    </div>

</x-login-layout>
