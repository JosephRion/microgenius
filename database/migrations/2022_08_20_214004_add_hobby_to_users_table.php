<?php
//Lesson 13Chapter 10.1 カラムを増やすマイグレーション https://techacademy.jp/my/php/laravel6/message-board#chapter-8-4 

// このページのURLは
// microgenius/database/migrations/2022_08_20_214004_add_hobby_to_users_table.php

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
    public function up()   { // nullを許容しない設定にしているのは下記のmigrationファイルです。2022.08.21  
        Schema::table('users', function (Blueprint $table) {
            //$table->string('hobby');  //カラムを追加 2022.08.15..1542 2022.08.20に再度使用。
                // userテーブルにhobbyカラムを追加する。
                // hobbyカラムはnullを許容しない。という意味になります。
                // つまり、初期のユーザ登録処理にはhobbyを登録する処理がないけれど
                // データベースにはhobbyは必須であるという指定がされているため
                // 結果として矛盾が発生してエラーになっています。
            $table->string('hobby')->nullable();  // カラムを追加 2022.08.21 ->nullable() で、null を yes に設定
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
