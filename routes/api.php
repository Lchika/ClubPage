<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザー
Route::get('/user', fn() => Auth::user())->name('user');

// 記事投稿
Route::post('/posts', 'PostController@create')->name('post.create');

// 記事一覧
Route::get('/posts', 'PostController@index')->name('post.index');

// 記事詳細
Route::get('/posts/{id}', 'PostController@show')->name('post.show');

// 記事更新
Route::put('/posts/{id}', 'PostController@update')->name('post.update');

// コメント
Route::post('/posts/{post}/comments', 'PostController@addComment')->name('post.comment');

// トークンリフレッシュ
Route::get('/reflesh-token', function (Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();

    return response()->json();
});

// 画像アップロード
Route::post('/images', function (Illuminate\Http\Request $request) {
    //$path = $request->file('image')->store('images');
    $path = Storage::disk('public')->putFile('upload/images', $request->file('image'), 'public');

    return response(['path' => Storage::url($path)], 201);
});

// ニュース投稿
Route::post('/news', 'NewsController@create')->name('news.create');

// ニュース一覧
Route::get('/news', 'NewsController@index')->name('news.index');

// タグ一覧
Route::get('/tags', 'TagController@index')->name('tag.index');