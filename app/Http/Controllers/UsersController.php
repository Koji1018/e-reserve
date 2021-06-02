<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加

class UsersController extends Controller
{
    // ユーザ一覧画面の表示用
    public function index()
    {
        // ユーザ一覧をnameの昇順で取得
        $users = User::orderBy('name', 'asc')->paginate(10);
        
        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    // ユーザ一覧画面の検索処理用
    public function search(Request $request)
    {
        // 検索するテキストが入力されている場合のみ一覧を取得する。
        if(!empty($request->name)) {
            $users = User::where('name', 'like', '%'.$request->name.'%')->paginate(10);
            
            // ユーザ一覧ビューでそれを表示
            return view('users.index', [
                'users' => $users,
            ]);
        }
        else{
            // ユーザ一覧画面にリダイレクト
            return redirect('/users');
        }
    }
}
