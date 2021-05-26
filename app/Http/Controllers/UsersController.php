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
}
