<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    //L15 C10.3追加。UsersController.phpやMicropostsController.phpのファイルがすでにありますが、
    //今回は中間テーブルを操作するアクションであるため新しくUserFollowController.phpファイルを作成します。
    
    /**
     * ユーザをフォローするアクション。
     *
     * @param  $id  相手ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function store($id) //storeメソッドではUser.phpに定義されているfollowメソッドを使って、ユーザをフォローできるようにします。
    {
        // 認証済みユーザ（閲覧者）が、 idのユーザをフォローする
        \Auth::user()->follow($id);
        // 前のURLへリダイレクトさせる
        return back();
    }

    /**
     * ユーザをアンフォローするアクション。
     *
     * @param  $id  相手ユーザのid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //destroyメソッドではUser.phpに定義されているunfollowメソッドを使って、ユーザをアンフォローできるようにします。
    {
        // 認証済みユーザ（閲覧者）が、 idのユーザをアンフォローする
        \Auth::user()->unfollow($id);
        // 前のURLへリダイレクトさせる
        return back();
    }
}
