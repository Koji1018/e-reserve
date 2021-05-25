<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reservation;

class ReservationsController extends Controller
{
    // トップページ画面の表示用
    public function index()
    {
        $data = [];
		if (\Auth::check()) { // 認証済みの場合				
			$user = \Auth::user(); // 認証済みユーザを取得
// 			$reservations = $user->reservations()->orderBy('lending_start', 'asc')->paginate(10); // ユーザの予約一覧を貸出開始日時の昇順で取得
			$data = [
				'user' => $user,
				// 'reservations' => $reservations,
			];
			return view('reservations.index_user', $data); // lendings/userビューでそれらを表示
		} else return view('auth.login');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
