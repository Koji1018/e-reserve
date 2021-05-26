<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ReservationsController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// 認証済なら許可
Route::group(['middleware' => ['auth']], function () {
    // カテゴリー一覧、追加、編集、削除
    Route::resource('categories', 'CategoriesController');
    // 備品一覧、追加、編集、削除
    Route::resource('equipments', 'EquipmentsController');
    // ユーザ一覧
	Route::resource('users', 'UsersController', ['only' => ['index']]);
	// 管理者一覧、追加
	Route::resource('admin', 'AdminController', ['only' => ['index']]);
	Route::group(['prefix' => 'admin/'], function () {
	    Route::get('add', 'AdminController@add')->name('admin.add');
	    Route::post('update', 'AdminController@update')->name('admin.update');
	});
});