<x-logout-layout>
    <!-- 適切なURLを入力してください -->
{!! Form::open(['url' => '/register']) !!}

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="register-box">
<p>新規ユーザー登録</p>

{{ Form::label('username','ユーザー名') }}
{{ Form::text('username',null,['class' => 'input']) }}

{{ Form::label('email','メールアドレス') }}
{{ Form::email('email',null,['class' => 'input']) }}

{{ Form::label('password','パスワード') }}
{{ Form::password('password',['class' => 'input']) }}

{{ Form::label('passwordconfirm','パスワード確認') }}
{{ Form::password('password_confirmation',['class' => 'input']) }}

{{ Form::submit('新規登録',['class' => 'btn btn-danger']) }}

<p><a href="login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}

</div>
</x-logout-layout>
