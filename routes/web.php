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
//追記  今まで / はRouterからControllerへ飛ばさずに直接welcomeのViewを表示させていました。
//Route::get('/', function () {
//    return view('welcome');
//});
//  Route::get('/', 'MicrogeniusesController@index');を導入したことにより、上記の定義は廃止。2022.08.13..2332TKT L15C9.2

//上記の記述を下記のように変更し、Controller ( MicrogeniusesController@index ) を経由してwelcomeを表示するようにします。
Route::get('/', 'MicrogeniusesController@index');//Controller ( MicrogeniusesController@index ) を経由してwelcomeを表示する


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
    
    //L15 C10.2 Router 追加
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');    // 追加 L15 C13.1 お気に入り用に追加 2022.07.13..1413TKT
    });
    
    //L15 C8.2
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);

    // 追加L15 C13.1 お気に入り用に追加 ここから 2022.07.13..1415TKT
    Route::group(['prefix' => 'microgeniuses/{id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
    });
    // 追加L15 C13.1 お気に入り用に追加 ここまで 2022.07.13..1415TKT
    
    
    //L15C9.2 Router
    //認証を必要とするルーティンググループ内に、 Microgeniusesのルーティングを設定します（登録のstoreと削除のdestroyのみ）。
    //これで、認証済みのユーザだけがこれらのアクションにアクセスできます。
    Route::resource('microgeniuses', 'MicrogeniusesController', ['only' => ['store', 'destroy']]); 
});

//ユーザが自分の名前を編集するアクション（edit, update)や退会アクション（destroy)を作っても問題ありませんし、
//さらにユーザの登録情報（年齢や自己紹介など）を充実（usersテーブルのカラム追加）させても良いでしょう。



