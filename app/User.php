<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'hobby', 'hometown', 'food',//'name', 'email', 'password',だった
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    /**
     * 
     * モデルと接続されるテーブル名は、モデル名によって決められます。
     * たとえば、 Messageモデルはmessagesテーブルと自動的に接続されます。
     * この規則を破って独自のテーブル名をつけたい場合に、 $table を使用します。
     * protected $table = [
    'microgeniuse'
    ];
     * protected $table = 'micro_geniuses'; これのせいで入れなくなっていた。
     */


     
    /**
     * L15 C9.1 User Model
     */
    public function microgeniuses()
    {
        return $this->hasMany(Microgeniuse::class);
    }
    
    /**
     * L15 C9.1 投稿機能. 2022.08.15..1055 sugimoto
     * Microgeniuseの数をカウントする機能を追加
     * Userが持つMicrogeniuseの数をカウントするためのメソッドも作成
     * loadCount メソッドの引数に指定しているのはリレーション名
     * アクションでこのメソッドを $user->loadRelationshipCounts() のように呼び出し、ビューで $user->microposts_count のように件数を取得することになります。
     * このユーザに関係するモデルの件数をロードする。
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microgeniuses', 'followings', 'followers', 'favorites']); //L15 C10.3で'followings', 'followers'を追記。//2022.08.15..1038 'favorites' を追加
        
        
    }

    /**
     * このユーザがフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    /**
     * このユーザをフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    /**
     * $userIdで指定されたユーザをフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function follow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // フォロー済み、または、自分自身の場合は何もしない
            return false;
        } else {
            // 上記以外はフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    /**
     * $userIdで指定されたユーザをアンフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function unfollow($userId)
    {
        // すでにフォローしているか
        $exist = $this->is_following($userId);
        // 対象が自分自身かどうか
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // フォロー済み、かつ、自分自身でない場合はフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 上記以外の場合は何もしない
            return false;
        }
    }

    /**
     * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
     *
     * @param  int  $userId
     * @return bool
     */
    public function is_following($userId)
    {
        // フォロー中ユーザの中に $userIdのものが存在するか
        return $this->followings()->where('follow_id', $userId)->exists();
    }

    /**
     * L15 C11.1 タイムラインの表示
     * このユーザとフォロー中ユーザの投稿に絞り込む。
     */
    public function feed_microgeniuses()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Microgeniuse::whereIn('user_id', $userIds);
    }


//---------------------------------------------------------------フォロー系はここまで//---------------------------------------------------------------
//---------------------------------------------------------------ここからはお気に入り登録・解除系//---------------------------------------------------------------
    
    /**
     * $userIdで指定されたユーザをフォローする。からお気に入り登録へ書き換え。
     *
     * @param  int  $userId
     * @return bool
     */
    public function favorite($microgeniuseId) //ここは単数形favoriteで表現しないといけないのだろう。followが単数形だったので。ただし、$microgeniuseIdへ変更
    {
        // すでにfavoriteお気に入りに追加しているかどうか
        $exist = $this->is_favorite($microgeniuseId); //

        if ($exist) { //$its_me = $this->id == $userId; を削除した関係で記述を更新
            // 既にお気に入り登録している場合は、何もしない
            return false;
        } else {
            // 上記以外はフォローする
            $this->favorites()->attach($microgeniuseId); //followings に相当するfavorites(複数形)。上との使われ方が異なっている
            return true;
        }
    }
    

    /**
     * このユーザがフォロー中のユーザ。（ Userモデルとの関係を定義）から持ってきた、お気に入り用の関数の定義。
     * Lesson 15Chapter 10.1 Model  多対多の関係
     * 
     */
    public function favorites()// あるUserが複数の投稿をお気に入りしますので、その関係を定義するメソッドは複数形のfavorites(複数形) とするのがわかりやすいです。
    {
        return $this->belongsToMany(Microgeniuse::class, 'favorites', 'user_id', 'microgeniuse_id')->withTimestamps(); //第一引数はMicrogeniuse::class
    }
    
    
    /**
     * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。から取ってきたお気に入り用のis_following→is_favorite関数定義
     *
     * @param  int  $userId
     * @return bool
     */
    public function is_favorite($microgeniuseId) //指定した情報($userId)がお気に入り済みかどうか判定する処理になります。紛らわしいため$userIdから$microgeniuseIdに変更。
    {
        // フォロー中ユーザの中に $userIdのものが存在するか。が元々。ここでは、お気に入り済みかどうか判定する処理をしている。
        return $this->favorites()->where('microgeniuse_id', $microgeniuseId)->exists(); //followings→複数形のfavoritesで受け止める。紛らわしいため$userIdから$microgeniuseIdに変更。
    }
     
 


    /**
     * $userIdで指定されたユーザをアンフォローする。から、お気に入りから削除へ書き換え
     *
     * @param  int  $userId
     * @return bool
     */
    public function unfavorite($microgeniuseId)  //お気に入り解除用のメソッド: unfavorite 単数形。動詞なら単数形で表記。紛らわしいので$userIdを$microgeniuseIdに修正
    {
        // すでにお気に入り登録してあるか
        $exist = $this->is_favorite($microgeniuseId); //紛らわしいので$userIdを$microgeniuseIdに修正
        // 対象が自分自身かどうか


        //if ($exist && !$its_me) { //これはフォローの話なので、上では削除した分、要修正
        if ($exist) {// 論理積	&&	x && y	左辺も右辺もtrueの場合にtrue（左辺 かつ 右辺）
            // お気に入り登録済み、済み、かつ、自分自身でない場合はお気に入りを解除する
            $this->favorites()->detach($microgeniuseId); //ここはfavorites複数形で。followingsに相当。紛らわしいので$userIdを$microgeniuseIdに修正
            return true;
        } else {
            // 上記以外の場合は何もしない
            return false;
        }
    }

    
    
}
