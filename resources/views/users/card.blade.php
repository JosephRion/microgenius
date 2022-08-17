<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="">
        
         {{-- Viewに削除ボタンをつけ足します。 
            Auth::id() = {!! Auth::id()  !!},
            $ user-> ={!! $user->id !!} である。
                <div>
                    ログインユーザーの時のみこれが表示されるようにする。
                    @if (Auth::id() == $user->id)
                        ログインユーザーのときだけこれが表示される。ifの中でも
                        Auth::id() = {!! Auth::id()  !!},
                        $ user-> ={!! $user->id !!} である。
                    @endif
                </div>
        --}}
    </div>
</div>
{{-- フォロー／アンフォローボタン --}}
@include('user_follow.follow_button')