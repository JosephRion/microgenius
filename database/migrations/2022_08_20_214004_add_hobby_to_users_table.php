<?php
//Lesson 13Chapter 10.1 カラムを増やすマイグレーション https://techacademy.jp/my/php/laravel6/message-board#chapter-8-4 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddhobbyToUsersTable extends Migration //ここのクラスはファイル名と一致していなければならないようだ。2022.08.15..1554TKTK
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('hobby');  //カラムを追加 2022.08.15..1542 2022.08.20に再度使用。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('hobby');//カラムを削除
        });
    }
}
