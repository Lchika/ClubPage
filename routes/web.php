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

// APIのURL以外のリクエストに対してはindexテンプレートを返す
// 画面遷移はフロントエンドのVueRouterが制御する
//Route::get('/{any?}', fn() => view('index'))->where('any', '.+');
Route::get('/posts/{id?}', 'PostSSRController@detail')->where('id', '.+');
Route::get('/posts', 'PostSSRController@posts');
Route::get('/columns', 'PostSSRController@columns');
Route::get('/works', 'PostSSRController@works');
Route::get('/news', 'PostSSRController@news');
Route::get('/about', 'PostSSRController@about');
Route::get('/tag/{tag?}', 'PostSSRController@tag')->where('tag', '.+');
Route::get('/{any?}', 'PostSSRController@index')->where('any', '.+');
