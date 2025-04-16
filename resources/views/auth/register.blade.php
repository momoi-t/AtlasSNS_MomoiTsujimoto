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

{{ Form::label('username','username') }}
{{ Form::text('username',null,['class' => 'input']) }}

{{ Form::label('email','mail address') }}
{{ Form::email('email',null,['class' => 'input']) }}

{{ Form::label('password','password') }}
{{ Form::text('password',null,['class' => 'input']) }}

{{ Form::label('passwordconfirm','password confirm') }}
{{ Form::text('password_confirmation',null,['class' => 'input']) }}

{{ Form::submit('REGISTER',['class' => 'btn btn-danger']) }}

<p><a href="login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}

</div>
</x-logout-layout>
