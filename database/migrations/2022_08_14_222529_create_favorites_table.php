<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user_id'); //お気に入り用 追記 
            $table->unsignedBigInteger('microgeniuse_id'); //お気に入り用 追記 2022.08.14..2446TKT ここを間違っていたのでリフレッシュもマイグレーションもできたなかった。リレーション先のテーブル名が、microgeniuses ですので、microgeniuse_idに合わせると良いでしょう。
            
            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //user_idはusersテーブルのidカラムと紐づいて
            $table->foreign('microgeniuse_id')->references('id')->on('microgeniuses')->onDelete('cascade'); //microgeniuse_idはmicrogeniusesテーブルのidカラムと紐づきます
            
            // user_idとmicrogeniuse_idの組み合わせの重複を許さない
            $table->unique(['user_id', 'microgeniuse_id']);
            

            $table->timestamps(); //元々からある行

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
