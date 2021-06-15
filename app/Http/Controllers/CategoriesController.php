<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Category;
use App\Equipment;

class CategoriesController extends Controller
{
    // カテゴリー一覧画面の表示用
    public function index()
    {
        // カテゴリー一覧をnameの昇順で取得
		$categories = Category::orderBy('name', 'asc')->paginate(10);
		
		// カテゴリー一覧ビューでそれを表示
		return view('categories.index', [
			'categories' => $categories,
		]);
    }

    // カテゴリー追加画面の表示用
    public function create()
    {
        // カテゴリー追加ビューでそれを表示
        return view('categories.create');
    }
    
    // カテゴリー追加処理用
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);
        
        // リクエストされた値をもとに作成
        $category = new Category;
        $category->name = $request->name;
        $category->save();

        // カテゴリー一覧画面にリダイレクト
        return redirect('/categories');
    }

    // カテゴリー編集画面の表示用
    public function edit($id)
    {
        // idの値でカテゴリーを検索して取得
        $category = Category::findOrFail($id);
        
        // カテゴリー編集ビューでそれを表示
        return view('categories.edit', [ 'category' => $category, ]);
    }

    // カテゴリー編集処理用
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);
        
        // idの値でカテゴリーを検索して取得
        $category = Category::findOrFail($id);
        
        // カテゴリー名を更新
        $category->name = $request->name;
        $category->save();
        
        // カテゴリー一覧画面にリダイレクト
        return redirect('/categories');
    }


    // カテゴリー削除画面の表示用
    public function delete(Request $request)
    {
        // チェックされた行のカテゴリーIDの配列
        $category_ids = $request->category;


        /* カテゴリー情報、備品数を取得して変数定義
           loadRelationshipCounts(loadCountメソッド)を利用する場合
           ※1件のカテゴリーずつしかできない。
        foreach($category_ids as $category_id) {
            $category = Category::findOrFail($category_id); // IDをもとにカテゴリーを取得
            $category->loadRelationshipCounts(); // 件数をロード
            $categories[] = $category; // 配列へ追加
        } */
        
        
        // カテゴリー情報、備品数を取得して変数定義(withCountメソッドを利用する場合)
        $categories = Category::withCount(['equipments',])->findOrFail($category_ids);
        
        // 各カテゴリーに紐づく備品の予約状況を取得。
        // カテゴリーの同じ備品の予約状況の合計を各カテゴリーに格納する。
        $r_total = 0;
        foreach($categories as $category) {
            $equipments = Equipment::withCount(['reserve_users',])->where('category_id',$category->id)->get();
            foreach($equipments as $equipment) {
                $r_total += $equipment->reserve_users_count;
            }
            $category->r_total = $r_total;
            $r_total = 0;
        }
        
        // カテゴリー削除ビューでそれを表示
		return view('categories.delete', [
			'categories' => $categories,
		]);
    }

    // カテゴリー削除処理用
    public function destroy(Request $request)
    {
        // 選択されたカテゴリーを削除
        foreach($request->category as $category){
            $delete_category = Category::findOrFail($category); // 取得
            $delete_category->delete(); //削除
        }
        
        // カテゴリー一覧画面にリダイレクト
        return redirect('/categories');
    }
}
