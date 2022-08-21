<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加 microgenius/app/Http/Controllers/MicrogeniusesController.php ではuse App\Microgeniuse; を追加したが、
//こっちmicrogenius/app/Http/Controllers/UsersController.phpでは既に追加していた。 2022.08.17..2600TKT

//https://readouble.com/laravel/6.x/ja/validation.html#rule-unique
//指定されたIDのuniqueルールを無視する
use Illuminate\Validation\Rule; //自分のメールアドレスを修正しなくても更新できるようにするための use//Rule::uniqueを使う際も名前空間の指定が必要なので、
use Illuminate\Support\Facades\Validator;
//このファイルで 1index, 2show, 3followings, 4followers, 5favorites,の５つのfunctionを規定していた。
//追加で、editと、updateとの２つも規定しなければならない。2022.08.17..2455TKT
//use App\Http\Controllers\Controller; //名前空間が同じなので、そのuseは不要で大丈夫かと思います
use Illuminate\Support\Facades\Hash; //パスワードのハッシュファサードのために追加2022.08.19..2242TKT

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
     */
     //findOrFailについて、findと同じく、指定されたレコードを取得しますが、findOrFail はレコードが存在しない時に404エラー（Not foundエラー）を出します。
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
    } //public function favoritesの閉じ括弧
    
    //---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
    //追加で、editと、updateとの２つも規定しなければならない。2022.08.17..2455TKT この下に追加する。

    //---------------------------------------------------------------//---------------------------------------------------------------
    /**
     * 'password' => $user, //ここは単数形ふたつともpassword            
     * この記述はControllerで用意した$userの中身(ユーザー情報)をviewファイルに$passwordという名前で使用できるようにするという意味になります。
     * 「$userの中身(ユーザー情報)をviewファイルに$passwordという名前で使用」というのは少しおかしくないでしょうか？
     * viewで使用する名称 => viewに渡したい情報
     * というルールになります。
     *  'user' => $user, 
     * ここは$userの中身(ユーザー情報)をviewで$userという変数名で使用できるようにするという意味になるので問題ないと思います。
     * 'password' => $password,
     * この$passwordはどこから登場しましたか？「変数は定義されていないと使用できない」ので現状だとエラーになると思います。
     * また、ここで指定するのは Viewで変数を使用したいから です。viewで変数を使用しないのであればここに指定は不要です。 $passwordという変数はviewで必要でしょうか？
     * 
     * 
    **/
    //パスワード用の編集editpass
     //L13 C8.7 MessagesControllerあっとedit 参照
    public function editpass($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id); //Microgeniuseからuserへ //ここで$userを定義しておく
        
        if (\Auth::id() === $user->id) { //条件文を書き換え
        return view('users.editpass', [ // プロフィール編集ビューでそれを表示//ここは複数形でusers
            'user' => $user, //ここは単数形ふたつとも
        ]);
        } //ifの閉じ括弧。
         else { //自分がログインしているuser_idじゃない投稿IDのURLを直打ちした場合にはトップページに返す。
            return redirect('/'); // トップページへリダイレクトさせる
         }
    } //public function editpassの閉じ括弧
    //---------------------------------------------------------------

    /**
     * microgenius/app/Http/Controllers/Auth/RegisterController.phpによると
                protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], //name は必須で、文字列、最大255文字まで
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], //emailは必須で、文字列、'email', 最大255文字まで, 既存のレコードに無いemailであること。
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    $request->validate  と Validator::make は
    どう違うのでしょうか。カリキュラムには記載されていないと思います
    どちらもバリデーションを行うという点では同じです。
    $request->validate の方だと | で文字列を区切って表記するため、今回使いたい
    Rule::unique('users')->ignore($user->id),
    を記述することができないです。今回は、配列でバリデーションを定義するValidator::makeの利用が必要になります。
    **/
    // パスワード専用のupdate
    public function updatepass(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            'password' => 'required|string|min:8|confirmed', 
            
        ]);
        
        // idの値でプロフィールを検索して取得
        $user = User::findOrFail($id);
        // プロフィールを更新
        // $user->password = $request->password; //passwordのファサードの前のコマンド
            // microgenius/app/Http/Controllers/Auth/RegisterController.php というファイルによると
            // 'password' => Hash::make($data['password']), //ここでhash ファサードされている。となっている
        $user->password = Hash::make($request->password);  // L15 C6.1 Modeo にて $user->password = Hash::make($request->password);
        
        $user->save();
        // トップページへリダイレクトさせる
        return redirect('/');
    } //public function updateの閉じ括弧
    
    // ここまでがパスワードの更新とハッシュファサード。
    //---------------------------------------------------------------//---------------------------------------------------------------//---------------------------------------------------------------
    
    //L13 C8.7 MessagesControllerあっとedit 参照
    public function edit($id) //これはOKだとおもっていたが。
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id); //Microgeniuseからuserへ //ここで$userを定義しておく
        
        //if (\Auth::id() === $user->user_id) {//編集を実行する部分は、if文で囲みました。@if (Auth::id() == $user->id)だった。 microgenius/resources/views/users/card.blade.phpでは 
        if (\Auth::id() === $user->id) { //条件文を書き換え
        // プロフィール編集ビューでそれを表示
        return view('users.edit', [ //ここは複数形でusers
            'user' => $user, //ここは単数形ふたつともuser
            
        ]);//ifで囲われた条件でこれを実行する。
        } //ifの閉じ括弧。
        
        
         else { //自分がログインしているuser_idじゃない投稿IDのURLを直打ちした場合にはトップページに返す。
            // トップページへリダイレクトさせる
            return redirect('/');
         }
    } //public function editの閉じ括弧
    
    //---------------------------------------------------------------
    
    //Lesson 13Chapter 8.8 MessagesController あっとupdate 2022.08.15追加。 2022.08.18追加。
    // put(updateのこと)またはpatchでusers/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        //バリデーション //更新のときには、既に自分が登録したメールアドレスは受け入れてもらえるようにしなければいけないから、記述を修正。
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.\Auth::id(),  //メールアドレスの本人以外での重複チェック
            'hobby' => 'max:255', //試しに5文字だけの入力制限 Lesson 13Chapter 10.2 //必須を取り外した。2022.08.21..2502TKT
            'hometown' => 'max:255',
            'food' => 'max:255',
        ]);
        //  https://readouble.com/laravel/6.x/ja/validation.html#rule-unique
        //  指定されたIDのuniqueルールを無視する
        
                    //Validator::make($request, [  ///$data は未定義とのこと。名前はsignup 時と同じ条件 microgenius/app/Http/Controllers/Auth/RegisterController.php
                        //'name' => ['required', 'string', 'max:255'], //name は必須で、文字列、最大255文字まで
                        //'email' => [ 'required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($user->id), ],  //user未定義
                    //   'email' => [ 'required', 'string', 'email', 'max:255' ],  //user未定義
                    //    ]);
        
        // idの値でプロフィールを検索して取得
        $user = User::findOrFail($id);
        
        // プロフィールを更新
        // $message->hobby = $request->hobby;    // L13C10.2カラム追加
        $user->name = $request->name;
        $user->email = $request->email;
        $user->hobby = $request->hobby; // hobbyカラムにデータを追加 2022.08.20
        $user->hometown = $request->hometown; // 
        $user->food = $request->food; // 
        
        $user->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    } //public function updateの閉じ括弧
    
    
} //class UsersController extends Controllerの閉じ括弧

