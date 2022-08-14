<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microgeniuse extends Model
{
    //L15 C9.1 マイグレーション後の処理。
    
    protected $fillable = ['content'];

    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     * 
     * モデル名が単数形で作成されたら実際のテーブルは複数です。
     * php artisan make:migration create_microgeniuses_table --create=microgeniuses
     * マイグレーションは実テーブル名なので複数形の microgeniuses です
     * モデルは単数形の Microgeniuse と作成ください
     * 単数形はMicrogenius だが、自動認識させるためにsを単に取り除いた形とする。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
}
