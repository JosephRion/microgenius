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
     * 
     * protected $table = 'micro_geniuses'; これのせいで入れなくなっていた。
     */
    

    
}
