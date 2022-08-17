<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="">
        この部位は全員表示される。
        Auth::id() = {!! Auth::id()  !!},
        $ user-> ={!! $user->id !!} である。
        
                        {{-- Viewに削除ボタンをつけ足します。 --}}
                        <div>
                            {{--ログインユーザーの時のみこれが表示されるようにする。--}}
                            @if (Auth::id() == $user->id)
                                ログインユーザーのときだけこれが表示される。ifの中でも
                                Auth::id() = {!! Auth::id()  !!},
                                $ user-> ={!! $user->id !!} である。
                            {{-- プロフィール編集ページへのリンク --}}
                            {{-- {!! link_to_route('messages.edit', 'プロフィールを編集', ['message' => $message->id], ['class' => 'btn btn-light']) !!}
                            {!! link_to_route('users.edit', 'プロフィールを編集', ['user' =>Auth::id()], ['class' => 'btn btn-light']) !!}--}}
                            {{-- プロフィール編集ページへのリンク--}}

                            @endif
                        </div>

    </div>
</div>
{{-- フォロー／アンフォローボタン --}}
@include('user_follow.follow_button')