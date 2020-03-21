<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsPost;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['index']);
    }
    
    /**
     * ニュース投稿
     * @param NewsPost $request
     * @return \Illuminate\Http\Response
     */
    public function create(NewsPost $request)
    {
        $news = new News();
        $news->id = $request->id;
        $news->date = $request->date;
        $news->body = $request->body;

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($news, 201);
    }

    /**
     * 記事一覧
     */
    public function index(Request $request)
    {
        $news_num = $request->input('quantity', 0);
        if($news_num <= 0){
            $news = News::orderBy('date', 'desc')->get();
        }else{
            $news = News::orderBy('date', 'desc')->take($news_num)->get();
        }
        return ['data' => $news];
    }
}
