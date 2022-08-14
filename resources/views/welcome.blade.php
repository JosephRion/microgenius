@extends('layouts.app')

@section('content')
{{-- L15 C9.3 controller --}}
    @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                {{-- L15 C11.3 で ユーザー情報の1行に集約 
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ Auth::user()->name }}</h3>
                    </div>
                    <div class="card-body">
                         認証済みユーザのメールアドレスをもとにGravatarを取得して表示 
                        <img class="rounded img-fluid" src="{{ Gravatar::get(Auth::user()->email, ['size' => 500]) }}" alt="">
                    </div>
                </div>--}}
                
                {{-- ユーザ情報 L15 C11.3 --}}
                @include('users.card')
            </aside>
            
            <div class="col-sm-8">
                {{-- 投稿フォーム L15 C9.6 追加--}}
                @include('microgeniuses.form')
                
                {{-- 投稿一覧 --}}
                @include('microgeniuses.microgeniuses')
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Microgeniuses</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection