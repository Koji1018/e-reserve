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
    Route::resource('categories', 'CategoriesController', ['except' => ['show','destroy']]);
    Route::group(['prefix' => 'categories/'], function () {
	    Route::get('delete', 'CategoriesController@delete')->name('categories.delete');
	    Route::delete('destroy', 'CategoriesController@destroy')->name('categories.destroy');
	});
    // 備品一覧、追加、編集、削除
    Route::resource('equipments', 'EquipmentsController', ['except' => ['show','destroy']]);
    Route::group(['prefix' => 'equipments/'], function () {
	    Route::get('delete', 'EquipmentsController@delete')->name('equipments.delete');
	    Route::delete('destroy', 'EquipmentsController@destroy')->name('equipments.destroy');
	    Route::get('search', 'EquipmentsController@search')->name('equipments.search');
	});
    // ユーザ一覧
	Route::resource('users', 'UsersController', ['only' => ['index']]);
	Route::group(['prefix' => 'users/'], function () {
	    Route::get('search', 'UsersController@search')->name('users.search');
	});
	
	// 管理者一覧、追加
	Route::resource('admin', 'AdminController', ['only' => ['index']]);
	Route::group(['prefix' => 'admin/'], function () {
	    Route::get('add', 'AdminController@add')->name('admin.add');
	    Route::post('update', 'AdminController@update')->name('admin.update');
	});
});