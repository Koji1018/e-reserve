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
