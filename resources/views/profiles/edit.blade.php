<x-login-layout>

    <div class="edit-form-container">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- アイコンとユーザー名 -->
            <div class="form-group">
            <img src="{{ $authIconPath }}" alt="ユーザーアイコン" class="user-icon">
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

            <!-- パスワード -->
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="new_password" id="new_password" class="input-area @error('new_password') is-invalid @enderror"required minlength="8" maxlength="20" pattern="[A-Za-z0-9]+" placeholder="英数字のみ">
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワード確認 -->
            <div class="form-group">
                <label for="password_confirmation">パスワード確認</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="input-area @error('new_password_confirmation') is-invalid @enderror"required minlength="8" maxlength="20" pattern="[A-Za-z0-9]+" placeholder="passwordと一致">
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
                <label for="icon_image">アイコンイメージ</label>
                <div class="input-area icon-image-input">
                <input type="file" name="icon_image" id="icon_image" class="upload-input @error('icon_image') is-invalid @enderror" accept="image/*" value="{{ old('icon_image') }}">
                @error('icon_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
            </div>
            <div class="profile-edit-btn">
            <button type="submit" class="btn btn-danger p-edit-btn">更新</button>
            </div>
        </form>
    </div>

</x-login-layout>
