<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
// ユーザ登録 
//追記
Route::get('/', function () {
    return view('welcome');
});




//L15 C6.2 Router RegistersUsersトレイト
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');


//Lesson 15Chapter 7.2 Router
// 認証 このルートが抜けていて、表示されていなかった。2022.08.13..2203TKT
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');


//L15 C8.2
//Router認証付きのルーティング
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
});

//ユーザが自分の名前を編集するアクション（edit, update)や退会アクション（destroy)を作っても問題ありませんし、
//さらにユーザの登録情報（年齢や自己紹介など）を充実（usersテーブルのカラム追加）させても良いでしょう。

//Route::get('/', 'MicropostsController@index');