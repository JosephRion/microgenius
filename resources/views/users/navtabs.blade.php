<ul class="nav nav-tabs nav-justified mb-3">
    {{-- ユーザ詳細タブ --}}
    <li class="nav-item">
        
        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            TimeLine
            <span class="badge badge-secondary">{{ $user->microposts_count }}</span>
        </a>
    </li>
    
    
    {{-- フォロー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.followings', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.followings') ? 'active' : '' }}">
            Followings
            <span class="badge badge-secondary">{{ $user->followings_count }}</span>
        </a>
    </li>
    
    {{-- フォロワー一覧タブ --}}
    <li class="nav-item">
        <a href="{{ route('users.followers', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.followers') ? 'active' : '' }}">
            Followers
            <span class="badge badge-secondary">{{ $user->followers_count }}</span>
        </a>
    </li>
    
    
    {{-- フォロワー一覧タブ を元にして お気に入りタブ--}}
    {{-- favorite お気に入り一覧タブ を右に1つ増やしてみた 2022.07.20--}}
    <li class="nav-item">
        <a href="{{ route('users.favorites', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.favorites') ? 'active' : '' }}">
            Favorites
            <span class="badge badge-secondary">{{ $user->favorites_count }}</span>{{-- ここでお気に入り数をカウント--}}
        </a>
    </li>
</ul>