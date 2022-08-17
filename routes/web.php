<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| ubuntu:~/environment/microgenius (main) $ php artisan route:list
*/
//今まで / はRouterからControllerへ飛ばさずに直接welcomeのViewを表示させていました。
//Route::get('/', function () {
//    return view('welcome');
//});//上記の定義は廃止。2022.08.13..2332TKT L15C9.2上記の記述を下記のように変更し、Controller ( MicrogeniusesController@index ) を経由してwelcomeを表示するようにします。
//Controller ( MicrogeniusesController@index ) を経由してwelcomeを表示する
Route::get('/', 'MicrogeniusesController@index'); //Method=GET|HEAD | URI=/ | Name= | Action=App\Http\Controllers\MicrogeniusesController@index |

//L15 C6.2 Router RegistersUsersトレイト
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get'); //Method=GET|HEAD | URI=signup | Name=signup.get | Action=App\Http\Controllers\Auth\RegisterController@showRegistrationForm | 
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post'); //Method=POST | URI= signup | Name =signup.post | Action=App\Http\Controllers\Auth\RegisterController@register |

//Lesson 15Chapter 7.2 Router// 認証 このルートが抜けていて、表示されていなかった。2022.08.13..2203TKT
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login'); //| Method=GET|HEAD | URI=login | Name=login |Action= App\Http\Controllers\Auth\LoginController@showLoginForm |
Route::post('login', 'Auth\LoginController@login')->name('login.post'); // | Method=POST | URI=login | Name=login.post | Action=App\Http\Controllers\Auth\LoginController@login                   | web,guest    |
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get'); //| Method=GET|HEAD | URI=logout | Name=logout.get | Action=App\Http\Controllers\Auth\LoginController@logout                  | web          |

//L15 C8.2//Router認証付きのルーティング //これで、認証済みのユーザだけがこれらのアクションにアクセスできます。
Route::group(['middleware' => ['auth']], function () {
    //Users
    //L15 C10.2 Router 追加
    Route::group(['prefix' => 'users/{id}'], function () { //認証付きの中で、followとお気に入り系。2022.08.16で投稿編集のルーティングを追加 //prefixを使用すると、第一引数に毎回 users と指定しなくても良くなります。あくまでも 重複する記述をまとめて簡潔にする だけの機能になります。
        Route::post('follow', 'UserFollowController@store')->name('user.follow'); //| Method=POST | URI=users/{id}/follow | Name=user.follow | Action=App\Http\Controllers\UserFollowController@store | web,auth |
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow'); //| Method=DELETE | URI=users/{id}/unfollow | Name=user.unfollow | Action=App\Http\Controllers\UserFollowController@destroy | web,auth |
        Route::get('followings', 'UsersController@followings')->name('users.followings'); //| GET|HEAD | users/{id}/followings         | users.followings      | App\Http\Controllers\UsersController@followings                   | web,auth     |
        Route::get('followers', 'UsersController@followers')->name('users.followers'); //   | GET|HEAD | users/{id}/followers          | users.followers       | App\Http\Controllers\UsersController@followers                    | web,auth     |
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');    // 追加 L15 C13.1 お気に入り用に追加 2022.07.13..1413TKT // | GET|HEAD | users/{id}/favorites          | users.favorites       | App\Http\Controllers\UsersController@favorites                    | web,auth     |
        //Route::get('messages/{id}/edit', 'MessagesController@edit')->name('messages.edit'); //2022.08.16で投稿編集のルーティングを追加
        //Route::get('micromessages', 'MicromessagesController@edit')->name('micromessages.edit'); 上記だと users/{id}/messages/{id}/edit になりませんか？
        //必要なのが「messages/{id}/edit」であれば、prefixのブロックの内側に配置するのはおかしい気がします。
    }); //Route::group(['prefix' => 'users/{id}'], function () の閉じ括弧
    
    //L15 C8.2
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]); //| GET|HEAD | users                         | users.index           | App\Http\Controllers\UsersController@index                        | web,auth     |
                                                                                //| GET|HEAD | users/{user}                  | users.show            | App\Http\Controllers\UsersController@show                         | web,auth     |
    //Route::get('profile/{id}/edit', 'ProfileController@edit')->name('profile.edit'); //プロフィールの編集             
    
    ////---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
    //microgeniuses
    // 追加L15 C13.1 認証付きの中で、お気に入り用に追加 ここから 2022.07.13..1415TKT
    Route::group(['prefix' => 'microgeniuses/{id}'], function () { //
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite'); //        | POST     | microgeniuses/{id}/favorite   | favorites.favorite    | App\Http\Controllers\FavoritesController@store                    | web,auth     |
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite'); //| DELETE   | microgeniuses/{id}/unfavorite | favorites.unfavorite  | App\Http\Controllers\FavoritesController@destroy                  | web,auth     |
        //Route::get('micromessages', 'MicromessagesController@edit')->name('micromessages.edit'); //これだとだと「 ‘microgeniuses/{id}’/micromessages」という意味になりますよ。
    }); // Route::group(['prefix' => 'microgeniuses/{id}'], function () {の閉じ括弧
    // 追加L15 C13.1 認証付きの中で、お気に入り用に追加 ここまで 2022.07.13..1415TKT
    
    //L15C9.2 Router
    //認証を必要とするルーティンググループ内に、 Microgeniusesのルーティングを設定します（登録のstoreと削除のdestroyのみ）。
    //Route::resource('microgeniuses', 'MicrogeniusesController', ['only' => ['store', 'destroy']]);  //| POST     | microgeniuses                 | microgeniuses.store   | App\Http\Controllers\MicrogeniusesController@store                | web,auth     |
    //store, destroyに updateを追加。
    Route::resource('microgeniuses', 'MicrogeniusesController', ['only' => ['store', 'destroy', 'update' ]]);  //|        | PUT|PATCH | microgeniuses/{microgenius}   | microgeniuses.update  | App\Http\Controllers\MicrogeniusesController@update               | web,auth     |
    //投稿の編集ページのURLへのアクセスが有った時の処理。//投稿の編集。まずは投稿の編集から。2022.08.17..1135TKT
    Route::get('microgeniuses/{id}/edit', 'MicrogeniusesController@edit')->name('microgeniuses.edit'); //投稿の編集。ルーティングを通すために、まずこっちでやってみる。2022.08.17..1153TKT
                                                                                    //| DELETE   | microgeniuses/{microgenius}   | microgeniuses.destroy | App\Http\Controllers\MicrogeniusesController@destroy              | web,auth     |
}); //Router認証付きのルーティングの閉じ括弧

//ユーザが自分の名前を編集するアクション（edit, update)や退会アクション（destroy)を作っても問題ありませんし、
//さらにユーザの登録情報（年齢や自己紹介など）を充実（usersテーブルのカラム追加）させても良いでしょう。

//Route::get('messages/{id}/edit', 'MessagesController@edit')->name('messages.edit');
//L13 C7.2  はい、エラーでは「MessagesController クラスが存在しません」と怒られています。
//そのクラスが実際には存在しないのに、ルーティング（routes/web.phpファイル等）にはそのクラス名が書かれてしまっている場合に、発生します。
//そのクラス名が正しくないのでしたら、ルーティングから削除しましょう。
//そのクラス名が正しいのでしたら、クラスを作成しましょう。


