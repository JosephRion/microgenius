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
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $microgeniuses = $user->microgeniuses()->orderBy('created_at', 'desc')->paginate(3);

            $data = [
                'user' => $user,
                'microgeniuses' => $microgeniuses,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
}
