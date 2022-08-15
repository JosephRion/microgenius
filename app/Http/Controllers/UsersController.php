<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加

class UsersController extends Controller
{
    public function index()
    {
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(3);  // 数字の投稿数で次のページに送るという【ページネーション】

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)  //L15 C8.3 UsersController にはなかった。 L15 C8.4 UsersController で追加
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // ユーザ詳細ビューでそれを表示。 L15 C9.6で廃止。
        // return view('users.show', [
        //     'user' => $user,
        // ]);
        
        // 関係するモデルの件数をロード。 L15 C9.6
        $user->loadRelationshipCounts();
        
        // ユーザの投稿一覧を作成日時の降順で取得
        $microgeniuses = $user->microgeniuses()->orderBy('created_at', 'desc')->paginate(3); //3投稿ごとに、次のページヘ。ページネーション。
        
        // ユーザ詳細ビューでそれらを表示。L15 C9.6
        return view('users.show', [
            'user' => $user,
            'microgeniuses' => $microgeniuses,
        ]);
        
    }
    
    /**
     * ユーザのフォロー一覧ページを表示するアクション。
     *
     * L15 C10.4 で追記
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followings($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロー一覧を取得
        $followings = $user->followings()->paginate(10);

        // フォロー一覧ビューでそれらを表示
        return view('users.followings', [
            'user' => $user,
            'users' => $followings,
        ]);
    }

    /**
     * ユーザのフォロワー一覧ページを表示するアクション。
     *
     * L15 C10.4 で追記
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function followers($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロワー一覧を取得
        $followers = $user->followers()->paginate(10);

        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
        ]);
    }
    
    
    /**
     * ユーザのfavorite お気に入り一覧ページを表示するアクション。
     * フォロワー一覧ページを表示するアクションをのところを模倣して
     * @param  $id  ユーザのid
     * @return \Illuminate\Http\Response
     * 参考
     * public function followers($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのフォロワー一覧を取得
        $followers = $user->followers()->paginate(10);

        // フォロワー一覧ビューでそれらを表示
        return view('users.followers', [
            'user' => $user,
            'users' => $followers,
        ]);
    }
     */
    public function favorites($id)  // お気に入り一覧を表示するコントローラのメソッドは、UsersControllerあっとfavoritesになります
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザのお気に入り一覧を取得
        $favorites = $user->favorites()->paginate(10); //followers からfavoritesに置換
        
        // お気に入り一覧ビューでそれらを表示
        return view('users.favorites', [ //第一引数には表示したいViewを指定。users.favorites は、resources/views/users/favorites.blade.php を意味します。
            'user' => $user,  //第二引数にはそのViewに渡したいデータの配列を指定します。連想配列形式として第二引数にセットする必要があります。
          
            'microgeniuses' => $favorites, //このfavoritesメソッド内で $micopostsを定義している箇所はありませんよね。

        ]);
    }
    
    
    
}