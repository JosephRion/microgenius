<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 2022.08.14..1304 L15 C10.1 にて追記
     */
    public function up()
    {
        Schema::create('user_follow', function (Blueprint $table) {
            $table->bigIncrements('id'); //元からある
            
            $table->unsignedBigInteger('user_id'); //2022.08.14..1304 L15 C10.1 にて追記
            $table->unsignedBigInteger('follow_id'); //2022.08.14..1304 L15 C10.1 にて追記
            
            $table->timestamps(); //元からある
            
            // 外部キー制約ここから//2022.08.14..1304 L15 C10.1 にて追記
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //onDeleteは参照先のデータが削除されたときにこのテーブルの行をどのように扱うかを指定します。
            $table->foreign('follow_id')->references('id')->on('users')->onDelete('cascade'); //cascade: 一緒に消す (このテーブルのデータも一緒に消えます）
            //onDelete('cascade') とすることで、ユーザテーブルのデータが削除されると同時に、それにひもづくフォローテーブルのフォロー、フォロワーのレコードも削除されるようにしました。

            // user_idとfollow_idの組み合わせの重複を許さない
            $table->unique(['user_id', 'follow_id']); //これは一度保存したフォロー関係を何度も保存しないようにテーブルの制約として入れています。
            // 外部キー制約ここまで//2022.08.14..1304 L15 C10.1 にて追記
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follow');
    }
}
