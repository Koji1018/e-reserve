<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Equipment;
use App\Category;

class EquipmentsController extends Controller
{
    // 備品一覧画面の表示用
    public function index()
    {
        // 備品一覧をnameの昇順で取得
		$equipments = Equipment::orderBy('name', 'asc')->paginate(20);
		
		// 備品一覧ビューでそれを表示
		return view('equipments.index', [
			'equipments' => $equipments,
		]);
    }

    // 備品追加画面の表示用
    public function create()
    {
        // フォームの入力項目用のインスタンスを生成
        $equipment = new Equipment;
        
        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id');
		
        // 備品追加ビューでそれを表示
        return view('equipments.create', [
            'equipment' => $equipment,
            'category' => $category,
        ]);
    }

    // 備品追加処理用
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255|unique:equipments',
        ]);
        
        // 選択されたカテゴリーの情報を取得
        $category = Category::findOrFail($request->category_id);
        
        // リクエストされた値をもとに作成
        $equipment = new Equipment;
        $equipment->name = $request->name;
        $equipment->category_id = $category->id;
        $equipment->status = 0;
        $equipment->save();
        
        
        // $request->create([
        //     'name' => $request->name,
        //     'category_id' => $request->category_id,
        //     'status' => 0, 
        // ]);

        // 備品一覧画面にリダイレクト
        return redirect('/equipments');
    }

    // 備品編集画面の表示用
    public function edit($id)
    {
        // idの値で備品を検索して取得
        $equipment = Equipment::findOrFail($id);
        
        // カテゴリー一覧をnameの昇順で、「キー:id、値:name」で取得(セレクトボックス用)
		$category = Category::orderBy('name', 'asc')->pluck('name', 'id');
		
        // 備品編集ビューでそれを表示
        return view('equipments.edit', [
            'equipment' => $equipment,
            'category' => $category,
        ]);
    }

    // 備品編集処理用
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        // idの値で備品を検索して取得
        $equipment = Equipment::findOrFail($id);
        
        // 備品情報を更新
        if ($equipment->name != $request->name) {
            $equipment->name = $request->name;
        }
        $equipment->category_id = $request->category;
        $equipment->status = $request->status;
        $equipment->save();
        
        // 備品一覧画面にリダイレクト
        return redirect('/equipments');
    }

    // 備品削除画面の表示用
    public function delete(Request $request)
    {
        // 備品一覧をnameの昇順で取得
		$equipments = Equipment::orderBy('name', 'asc')->get();
        
        //dd($user);   // 追加
        
        // 備品削除ビューでそれを表示
		return view('equipments.delete', [
			'equipments' => $equipments,
		]);
    }

    // 備品削除処理用
    public function destroy(Request $request)
    {
        //
    }
}
