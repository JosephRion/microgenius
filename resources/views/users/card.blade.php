<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        {{-- L15 C10.4 view でファイル新規作成ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
        <img class="rounded img-fluid" src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="">
        ここに、ログインユーザーだけに現れる本人だけの編集ボタンを置く

    </div>
</div>
{{-- フォロー／アンフォローボタン --}}
@include('user_follow.follow_button')