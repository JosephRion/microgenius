@extends('layouts.app')

@section('content')
{{--
参考ファイルは
message-board/resources/views/messages/edit.blade.php

このファイルは
microgenius/resources/views/microgeniuses/edit.blade.php
--}}

    <h1>id: {{ $microgeniuse->id }} のメッセージ編集ページ</h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($microgeniuse, ['route' => ['microgeniuses.update', $microgeniuse->id], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('content', '投稿内容:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>
                
                {!! Form::submit('Update!', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection