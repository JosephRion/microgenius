<?php
namespace App\Http\Controllers;


class FavoritesController extends Controller  //クラス名の定義。PHPにはこの名前のクラスで認識されます

{
    //フォロー機能 開始タグ L15 C10.3
    /**
     * ユーザをフォローするアクション。
     *
     * @param  $id  相手ユーザのid
     * @return \Illuminate\Http\Response
     */
    /**

    //フォロー機能 閉じタグ
    を参考に **/
    public function store($id) //お気に入りに登録する関数。お気に入り登録のメソッド
    //$id は、メソッドの引数として定義されていますね。ですので、メソッド呼び出し元から、その値が渡されていることになります。
    // microposts/routes/web.php にroute::の設定が書いてある。
    {
        // 認証済みユーザ（閲覧者）が、 idの投稿を、お気に入り登録する

           \Auth::user()->favorite($id); //これで合っていますよ。2022.07.26..1039TKT mentor-sugimoto  10:39。これだと、他人の投稿をfavoriteとかunfovoriteとかに変えられるが、その人の全投稿が一気に変わってしまう。かつ、お気に入りにカウントされない。
           

        // 前のURLへリダイレクトさせる
        return back();
    }


    /**
     * ユーザをアンフォローするアクション。
     *
     * @param  $id  相手ユーザのid
     * @return \Illuminate\Http\Response
     */
    /** destroyを参考に
    public function destroy($id) //unfavoriteの関数。favoriteのレコードを削除するメソド
    {
        // 認証済みユーザ（閲覧者）が、 idのユーザをアンフォローする
        \Auth::user()->unfollow($id);
        // 前のURLへリダイレクトさせる
        return back();
    }
    これを参考に */
        public function destroy($id) //unfavoriteの関数。favoriteのレコードを削除するメソド
    {
        // 認証済みユーザ（閲覧者）が、 idの投稿のお気に入りレコードを削除する
     // \Auth::user()->unfollow($id); //アンフォローのときはこれ
        \Auth::user()->unfavorite($id); //お気に入り登録解除する
        // 前のURLへリダイレクトさせる
        return back();
    }
    //アンフォロー機能 閉じタグ
}
