<x-logout-layout>

    <div class="added-box">
      <div class="clear">
      <p>{{ session('username') }}さん</p>
      <p>ようこそ！AtlasSNSへ</p>
      </div>
      <div class="added-message">
      <p>ユーザー登録が完了いたしました。</p>
      <p>早速ログインをしてみましょう！</p>
      </div>

      <p class="btn btn-danger"><a href="login">ログイン画面へ</a></p>
    </div>
</x-logout-layout>
