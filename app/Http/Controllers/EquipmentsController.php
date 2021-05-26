<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Equipment;

class EquipmentsController extends Controller
{
     // 備品一覧画面の表示用
    public function index()
    {
        // 備品一覧をnameの昇順で取得
		$equipments = Equipment::orderBy('name', 'asc')->paginate(10);
		
		// 備品一覧ビューでそれを表示
		return view('equipments.index', [
			'equipments' => $equipments,
		]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
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
