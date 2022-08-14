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
        'name', 'email', 'password',
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
     * このユーザが所有する投稿。（ Microgeniuseモデルとの関係を定義）
     * serのインスタンスからそのUserが持つMicropostsを 
     * $user->microgeniuses()->get() もしくは $user->microgeniuses
     * という簡単な記述で取得できるようになります。
     */
    public function microgeniuses()
    {
        return $this->hasMany(Microgeniuse::class);
    }
    
    /**
     * Micropostの数をカウントする機能を追加
     * Userが持つMicrogeniuseの数をカウントするためのメソッドも作成
     * loadCount メソッドの引数に指定しているのはリレーション名
     * 
     * このユーザに関係するモデルの件数をロードする。
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount('microgeniuses');
    }

    
}
