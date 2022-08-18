@extends('layouts.app')

@section('content')
{{--
参考ファイルは
message-board/resources/views/messages/edit.blade.php
microgenius/resources/views/microgeniuses/edit.blade.php
microgenius/resources/views/users/edit.blade.php
このファイルは
/microgenius/resources/views/users/editpass.blade.php
こっちはプロフィール編集のページ
--}}

    <h1>{{--id: {{ $user->id }} --}}ご自身のログインパスワード編集ページ</h1>
            {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <p><img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 200]) }}" alt=""></p>


    <div class="row">
        <div class="col-6">
            {!! Form::model($user, ['route' => ['users.updatepass', $user->id], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('password', 'Password (at least 8 characters needed):') !!}
                    {!! Form::text('password', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('password', 'Password (confirm):') !!}
                    {!! Form::text('password', null, ['class' => 'form-control']) !!}
                    
                </div>
                
                {!! Form::submit('パスワードをUpdate!', ['class' => 'btn btn-primary']) !!}  {{--更新ボタン--}}<br><br><br>（※ なお、プロフィールのうち、名前、メールアドレスなどの項目の編集は⇒ <a
                href='{!! route('users.edit',  ['id' => Auth::id()] , ['class' => 'btn btn-light ']) !!}'"> Edit profile </a>こちらのリンクから おこなえます。）
            {!! Form::close() !!}
        </div><br>
    </div>
@endsection