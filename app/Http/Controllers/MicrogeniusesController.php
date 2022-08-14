<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicrogeniusesController extends Controller
{
    //L15 C9.3 MicrogeniusesController
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点L15 C9.3ではこのユーザの投稿のみ取得します）
            $microgeniuses = $user->microgeniuses()->orderBy('created_at', 'desc')->paginate(3);

            $data = [
                'user' => $user,
                'microgeniuses' => $microgeniuses,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    
    
    public function store(Request $request)
    {
        // バリデーション L15 C9.4 
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->microgeniuses()->create([
            'content' => $request->content,
        ]);

        // 前のURLへリダイレクトさせる
        return back();
    }
    
    
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $microginiuse = \App\Microgeniuse::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        //他者のMicropostを勝手に削除されないよう、ログインユーザのIDとMicropostの所有者のID（user_id）が一致しているかを調べている. 2022.08.14..1220TKT
        if (\Auth::id() === $microgeniuse->user_id) {//削除を実行する部分は、if文で囲みました。
            $microgeniuse->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
    
    
}
