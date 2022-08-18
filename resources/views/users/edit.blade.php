@extends('layouts.app')

@section('content')
{{--
参考ファイルは
message-board/resources/views/messages/edit.blade.php
microgenius/resources/views/microgeniuses/edit.blade.php

このファイルは
microgenius/resources/views/users/edit.blade.php
こっちはプロフィール編集のページ
--}}

    <h1>{{--id: {{ $user->id }} --}}ご自身のプロフィール編集ページ</h1>
            {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <p><img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 200]) }}" alt=""></p>
<p>プロフィール画像を登録したい場合は、<br>
<a href="https://ja.gravatar.com/" target="_blank" rel="noopener noreferrer">Gravatar のウェブサイト https://ja.gravatar.com/</a>
<br>にて、メールアドレスとプロフィール写真を<br>
登録（無料）していただくと、こちらのプロフィール画像として表示されます。</p>

    <div class="row">
        <div class="col-6">
            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) !!}
                <div class="form-group">
                    
                    {!! Form::label('name', 'Name (必須) :') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('email', 'Email (必須) :') !!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    
                    {{-- パスワードは別ページで編集
                    {!! Form::label('content', 'Password:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('content', 'Password (confirm):') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                    --}}
                    
                </div>
                
                {!! Form::submit('Update!', ['class' => 'btn btn-primary']) !!}  {{--更新ボタン--}}<br><br><br>（※ なお、パスワードの変更は⇒ こちらのリンクから おこなえます。）
            {!! Form::close() !!}
        </div><br>
    </div>
@endsection