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
                        {!! link_to_route('users.show', $microgeniuse->user->name, ['user' => $microgeniuse->user->id]) !!}
                        <span class="text-muted">posted at {{ $microgeniuse->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($microgeniuse->content)) !!}</p>
                    </div>
                    
                    {{-- 削除ボタンとお気に入りボタンの横並びをひとまとめにするパーツ。ここから --}}
                    <div class="d-flex flex-row ">
                        

                        
                        {{--お気に入り登録ボタンあり--}}
                        <div>
                        @include('microgeniuse_favorite.favorite_button')
                        </div>
                        {{-- if条件無しでいつでも表示させるためのfavoriteお気に入りのフォーム ここまで --}}
                        
                        {{-- お気に入りボタンの前に半角スペースをつけ足します。2022.07.25..12.11 --}}
                        <div>
                        &nbsp;
                        </div>
                      {{-- お気に入りボタンの前に半角スペースをつけ足します。ボタン同士がくっつかないようにするための半角スペース2022.07.25..12.11 --}}
                        
                    
                        {{-- Viewに削除ボタンをつけ足します。 --}}
                        <div>
                            @if (Auth::id() == $microgeniuse->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                {{--microgeniuses_blade_php ファイル の投稿削除ボタンはこの位置--}}
                                {!! Form::open(['route' => ['microgeniuses.destroy', $microgeniuse->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                                
                            @endif
                        </div>
                        
                    </div>
                    {{-- 削除ボタンとお気に入りボタンの横並びをひとまとめにするパーツ。ここまで --}}
            
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $microgeniuses->links() }}
@endif