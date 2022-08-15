@extends('layouts.app')

@section('content')
{{--L15 C8.4 UsersControllerなどあったが、L15 C10.4 show で大幅に書き換え--}}
    <div class="row">
        <aside class="col-sm-4">
            {{-- ユーザ情報 --}}
            @include('users.card')
        </aside>
        
        <div class="col-sm-8">
            {{-- タブ --}}
            @include('users.navtabs')
            
            @if (Auth::id() == $user->id)
                {{-- 投稿フォーム --}}
                
                @include('microgeniuses.form')
            @endif
            {{-- 投稿一覧 --}}
            
            @include('microgeniuses.microgeniuses')
        
        </div>
    </div>
@endsection