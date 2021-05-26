<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class AdminController extends Controller
{
    // 管理者一覧画面の表示用
    public function index()
    {
        // 管理者一覧をnameの昇順で取得
        $admins = User::where('user_group','0')->orderBy('name', 'asc')->paginate(10);
        
        // 管理者一覧ビューでそれを表示
        return view('admin.index', [
            'admins' => $admins,
        ]);
    }
    
    // 管理者追加画面の表示用
    public function add()
    {
        // ユーザ追加ビューへ遷移
        return view('admin.add');
    }

    // 管理者追加処理用
    public function update(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        // ユーザが存在か調べる
        $exist = User::where('name', $request->name)->exists();
        
        // ユーザが存在する場合
        if ($exist) {
            // ユーザ情報を取得
            $user = User::where('name',$request->name)->first();
            
            // 管理者でない場合
            if ($user->user_group != 0) {
                // ユーザのユーザ種別を変更する
                $user->user_group = 0;
                $user->save();
            }
        } 
        // 管理者一覧画面に遷移
        return AdminController::index();
    }
}
