<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">Microgeniuses</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                
                @if (Auth::check())
                     {{-- L15C8.3 ユーザ一覧ページへのリンク.Auth::id() というクラスメソッド.ログインユーザのIDを取得することができるメソッドで、Auth::user()->id と同じ動き --}}
                    <li class="nav-item">{!! link_to_route('users.index', 'Users', [], ['class' => 'nav-link']) !!}</li>
                    
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a> {{--クリックしたら3段腹が出来る仕組み--}}
                        <ul class="dropdown-menu dropdown-menu-right">
                            
                            {{-- L15 C8.4 UsersControllerユーザ詳細ページへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('users.show', 'My profile', ['user' => Auth::id()]) !!}</li>
                            
                            <li class="dropdown-divider"></li> {{-- 横棒線 --}}
                            
                            {{-- お気に入り投稿一覧ページへのリンク --}}
                            <li class="dropdown-item">
                                
{{--これが機能するより良いリンクの2つ目--}}{!! link_to_route('users.favorites', 'Favorite', ['id' => Auth::id()]) !!}

                            </li>
                            
                            <li class="dropdown-divider"></li>{{-- 横棒線 --}}

                            {{-- ログアウトへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('logout.get', 'Logout') !!}</li>
                        
                        </ul> {{--<ul class="dropdown-menu dropdown-menu-right">の閉じカッコ--}}

                    </li>
                @else
                    {{-- ユーザ登録ページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('signup.get', 'Signup', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ログインページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('login', 'Login', [], ['class' => 'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
    </nav>
</header>