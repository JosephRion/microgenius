<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    
    <div class="card-body">{{--  class="text-center" ここに入れては編集ボタンには効かない--}}
        {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="">
        
        
            @if (Auth::id() == $user->id)
                <div  class="text-center" > {{-- class="center-block" は古い。class="d-flex justify-content-center"  class="mx-auto"  style="width: 200px;" 2022.08.18 Yuri ISHIKAWA 09:00--}}
                    <br> 
                {{--ログインユーザーの時のみこれが表示されるようにする。<br> 
                ifの中で<br>
                Auth::id() = {!! Auth::id()  !!},<br>
                $ user-> ={!! $user->id !!} である。<br>--}}
                
                {!! link_to_route('users.edit',  '自分のプロフィールを編集する',  ['id' => $user->id] , ['class' => 'btn btn-light '])  !!}
                </div> {{-- .="center-block"の閉じ括弧 --}}
            @endif
        
    </div>
</div>
{{-- フォロー／アンフォローボタン --}}
@include('user_follow.follow_button')