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
<p>プロフィール画像は、Gravatar のウェブサイト<br>
<a href="https://ja.gravatar.com/" target="_blank" rel="noopener noreferrer">https://ja.gravatar.com/</a>
<br>で、メールアドレスとプロフィール写真を<br>
登録（無料）していただくと、更新できます。</p>
<p>プロフィール画像を埋め込みたい方は<br>
<a href="https://ja.gravatar.com/" target="_blank" rel="noopener noreferrer">https://ja.gravatar.com/</a>
<br>に行っていただき、<br>
メールアドレスでご自身のアカウントを作成し、<br>
そこにプロフィール写真をアップロードしてご登録ください。</p>
    <div class="row">
        <div class="col-6">
            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) !!}
                <div class="form-group">
                    
                    {!! Form::label('content', 'Name:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('content', 'Email:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('content', 'Password:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                    
                    {!! Form::label('content', 'Password (confirm):') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                    
                </div>
                
                {!! Form::submit('Update!', ['class' => 'btn btn-primary']) !!}  {{--更新ボタン--}}
            {!! Form::close() !!}
        </div>
    </div>
@endsection