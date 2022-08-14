@if (count($microgeniuses) > 0)
    {{-- 2022.08.13..2339TKT  L15 C9.3 Controller --}}
    <ul class="list-unstyled">
        @foreach ($microgeniuses as $microgeniuse)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($microgeniuse->user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $microgeniuse->user->name, ['user' => $microgenius->user->id]) !!}
                        <span class="text-muted">posted at {{ $microgeniuse->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($microgeniuse->content)) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $microgeniuses->links() }}
@endif