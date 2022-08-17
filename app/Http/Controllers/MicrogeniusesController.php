<?php
namespace App\Http\Controllers; //どちらにしても「名前空間」が指定されていれば動作はします。

use Illuminate\Http\Request;

use App\Microgeniuse; //メッセージ編集のために、追加。//カリキュラムL13C8.3によると、このControllerは App\Message のModel操作が主な役割なので、 use App\Message; しておきます。これでわざわざ App の名前空間を書かなくてよくなります。つまり Message::all() で良いわけです。

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
            //$user->microposts() としていた部分を $user->feed_microposts() に変更しています。L15 C11.2 2022.08.14..1434TKT
            $microgeniuses = $user->feed_microgeniuses()->orderBy('created_at', 'desc')->paginate(3);


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
            //'hobby' => 'required|max:255',   // 2022.08.15..1820 追加
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
                //$microgeniuse = \App\Microgeniuse::findOrFail($id); //
        $microgeniuse = Microgeniuse::findOrFail($id); //名前空間を指定するには (1) App\Message のように名前空間 + クラス名を指定する (2)ファイルの先頭に use App\Message; と指定する,のどちらかにしてください。
                //統一されているのが望ましいので、②を採用するのであれば App\Message は Message に統一した方が良いですね。

                // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
                //他者のMicropostを勝手に削除されないよう、ログインユーザのIDとMicropostの所有者のID（user_id）が一致しているかを調べている. 2022.08.14..1220TKT
        if (\Auth::id() === $microgeniuse->user_id) {//削除を実行する部分は、if文で囲みました。
            $microgeniuse->delete(); //ifで囲われた条件でこれを実行する。
        } //ifの閉じ括弧

        // 前のURLへリダイレクトさせる
        return back();
    }
    
    //L13 C8.7 MessagesControllerあっとedit 
    // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $microgeniuse = Microgeniuse::findOrFail($id); //MessageからMicrogeniuseへ //ここで$microgeniuseを定義しておく
        
        if (\Auth::id() === $microgeniuse->user_id) {//削除を実行する部分は、if文で囲みました。
        // メッセージ編集ビューでそれを表示
        return view('microgeniuses.edit', [ //ここは複数形でmicrogeniuses
            'microgeniuse' => $microgeniuse, //ここは単数形モドキでふたつともmicrogeniuse
        ]);//ifで囲われた条件でこれを実行する。
        } //ifの閉じ括弧
         else { //自分がログインしているuser_idじゃない投稿IDのURLを直打ちした場合にはトップページに返す。
            // トップページへリダイレクトさせる
            return redirect('/');
         }
        
    }
    
    //Lesson 13Chapter 8.8 MessagesController あっとupdate 2022.08.15
    // putまたはpatchでmessages/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            //'hobby' => 'required|max:255',   // L13C10.2カラム追加 2
            'content' => 'required|max:255',
        ]);
        
        // idの値でメッセージを検索して取得
        $microgeniuse = Microgeniuse::findOrFail($id);
        // メッセージを更新
        // $message->hobby = $request->hobby;    // L13C10.2カラム追加
        $microgeniuse->content = $request->content;
        
        $microgeniuse->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
    
}
