<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    
    <div class="card-body">{{--  class="text-center" ここに入れては編集ボタンには効かない--}}
        {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="">
        
        <div > <br>
        趣味： {{ $user->hobby }}
        </div>
        
        {{-- Auth::id() = {!! Auth::id()  !!},<br>
        $ user-> ={!! $user->id !!} である。<br>--}}
        {{-- class="center-block" は古い。class="d-flex justify-content-center"  class="mx-auto"  style="width: 200px;" 2022.08.18 Yuri ISHIKAWA 09:00--}}
        {{--右上の microgenius/resources/views/commons/navbar.blade.phpに埋め込むことにしたので、ここからは削除しようとしたが、残しておくことにする--}}
            @if (Auth::id() == $user->id)
                <div  class="text-center" > 
                    <br> 
                {!! link_to_route('users.edit',  '自分のプロフィールを編集する',  ['id' => $user->id] , ['class' => 'btn btn-light '])  !!}
                </div>
            @endif
    </div>
</div>
{{-- フォロー／アンフォローボタン --}}
@include('user_follow.follow_button')