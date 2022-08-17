@extends('layouts.app')

@section('content')
{{--cf)    ここにページ毎のコンテンツを書く 
message-board/resources/views/messages/edit.blade.php

このファイルは
microgenius/resources/views/microgeniuses/edit.blade.php
エラー表示確認用
@if (count($errors) > 0)
        <ul class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <li class="ml-4">{{ $error }}</li>
            @endforeach
        </ul>
@endif
--}}   



    <h1>id: {{ $microgeniuse->id }} のメッセージ編集ページ。</h1>

    <div class="row">
        <div class="col-6">
            {{-- 
            {!! Form::model($microgeniuse, ['route' => ['microgeniuses.update', $microgeniuse->id], 'method' => 'put']) !!}

                <div class="form-group">
                    {!! Form::label('content', 'メッセージ:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
--}}
@endsection