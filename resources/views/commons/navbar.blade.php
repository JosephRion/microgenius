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
                            
                            {{-- L15 C8.4 UsersController自分のユーザ詳細ページへのリンク --}}
                            {{--廃止      <li class="dropdown-item">{!! link_to_route('users.show', 'My profile', ['user' => Auth::id()]) !!}</li> カリキュラム通りの記述だが、余白をクリックして青く反応しているにも関わらず、文字列をクリックしないと遷移しない。--}} 
                            <li class="dropdown-item" onclick="location.href='{!! route('users.show',  ['user' => Auth::id()]) !!}'"> <a href='{!! route('users.show',  ['user' => Auth::id()]) !!}'"> My profile </a> </li>   {{-- JavaScriptで余白クリックも反応する記述 2022.08.15..1503TKT --}}
                            
                            <li class="dropdown-divider"></li> {{-- 横棒線 --}}
              {{--問題有り。<li class="dropdown-item" onclick="location.href='{!! route('users.edit',  ['id' => $user->id] , ['class' => 'btn btn-light ']) !!}'"> <a href='{!! route('users.edit',  ['id' => $user->id] , ['class' => 'btn btn-light ']) !!}'"> Edit profile </a> </li>--}} 
                            {{--問題なのはルートパラメータに指定する情報です。 $user を使用するとControllerから情報を渡さないといけませんので、 Auth::id() を使用する必要があります。--}}
                            <li class="dropdown-item" onclick="location.href='{!! route('users.edit',  ['id' => Auth::id()] , ['class' => 'btn btn-light ']) !!}'"> <a href='{!! route('users.edit',  ['id' => Auth::id()] , ['class' => 'btn btn-light ']) !!}'"> Edit profile </a> </li>
                            
                            
                            <li class="dropdown-divider"></li> {{-- 横棒線 --}}
                            
                            {{-- お気に入り投稿一覧ページへのリンク --}}
                            {{--廃止<li class="dropdown-item">   {!! link_to_route('users.favorites', 'Favorite', ['id' => Auth::id()]) !!}  </li> 機能する2ndリンク。カリキュラム通りの記述だが、余白をクリックして青く反応しているにも関わらず、文字列をクリックしないと遷移しない。--}} 
                            <li class="dropdown-item" onclick="location.href='{!! route('users.favorites',  ['id' => Auth::id()]) !!}'"> <a href="{!! route('users.favorites', ['id' => Auth::id()]) !!}"> Favorite </a> </li>{{-- JavaScriptで余白クリックも反応する記述 2022.08.15..1503TKT ito-msメンター --}}
                                
                            <li class="dropdown-divider"></li>{{-- 横棒線 --}}

                            {{-- ログアウトへのリンク --}}
                            {{--廃止<li class="dropdown-item">{!! link_to_route('logout.get', 'Logout') !!}</li> カリキュラム通りの記述だが、余白をクリックして青く反応しているにも関わらず、文字列をクリックしないと遷移しない。--}} 
                            <li class="dropdown-item" onclick="location.href='{!! route('logout.get', 'Logout') !!}'"> <a href='{!! route('logout.get', 'Logout') !!}'"> Logout </a> </li>{{-- JavaScriptで余白クリックも反応する記述 2022.08.15..1503TKT --}}
                        
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