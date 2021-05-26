<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;

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
        // フォームの入力項目用のインスタンスを生成
        $category = new Category;
        
        // カテゴリー追加ビューでそれを表示
        return view('categories.create', [ 'category' => $category, ]);
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

        // 管理者一覧画面に遷移
        return CategoriesController::index();
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
