<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\StoreComment;
use App\Post;
use App\Comment;
use App\Tag;
use App\Tagmap;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['index', 'show', 'addComment']);
    }

    /**
     * 記事投稿
     * @param StorePost $request
     * @return \Illuminate\Http\Response
     */
    public function create(StorePost $request)
    {
        $post = new Post();
        $post->id = $request->id;
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        if(empty($request->abstract)){
            $post->abstract = "";
        }else{
            $post->abstract = $request->abstract;
        }
        if(empty($request->thumbnail) || $request->thumbnail == ""){
            $post->thumbnail = $this->getAlterThumbnail($request->category_id);
        }else{
            $post->thumbnail = $request->thumbnail;
        }
        $post->save();
        
        if(!empty($request->tags)){
            foreach ($request->tags as $key => $tag) {
                if(!is_array($tag) || !array_key_exists('text', $tag)){
                    continue;
                }
                $tag_name = $tag["text"];
                if(!Tag::where('name', $tag_name)->exists()){
                    $new_tag = new Tag();
                    $new_tag->name = $tag_name;
                    $new_tag->save();
                }else{
                    $new_tag = Tag::where('name', $tag_name)->first();
                }
                $new_tag_map = new Tagmap();
                $new_tag_map->post_id = $request->id;
                $new_tag_map->tag_id = $new_tag->id;
                $new_tag_map->save();
            }
        }

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($post, 201);
    }

    /**
     * 記事更新
     * @param StorePost $request
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request)
    {
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        if(empty($request->abstract)){
            $post->abstract = "";
        }else{
            $post->abstract = $request->abstract;
        }
        if(empty($request->thumbnail) || $request->thumbnail == ""){
            $post->thumbnail = $this->getAlterThumbnail($request->category_id);
        }else{
            $post->thumbnail = $request->thumbnail;
        }
        
        // タグを上書きするため、本記事に紐づいているタグマップを全削除する
        Tagmap::where('post_id', $request->id)->delete();

        if(!empty($request->tags)){
            foreach ($request->tags as $key => $tag) {
                if(!is_array($tag) || !array_key_exists('text', $tag)){
                    continue;
                }
                $tag_name = $tag["text"];
                if(!Tag::where('name', $tag_name)->exists()){
                    $new_tag = new Tag();
                    $new_tag->name = $tag_name;
                    $new_tag->save();
                }else{
                    $new_tag = Tag::where('name', $tag_name)->first();
                }
                $new_tag_map = new Tagmap();
                $new_tag_map->post_id = $request->id;
                $new_tag_map->tag_id = $new_tag->id;
                $new_tag_map->save();
            }
        }
        $post->save();

        return $post;
    }


    /**
     * 記事一覧
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $posts = Post::with(['category', 'tags']);
        if (isset($category)) {
            $posts = $posts->where('category_id', $category);
        }
        $tag = $request->input('tag');
        if (isset($tag)) {
            $tag_id = Tag::all()->where('name', $tag)->first()->id;
            $post_ids = Tagmap::all()->where('tag_id', $tag_id)->pluck('post_id');
            $posts = $posts->whereIn('id', $post_ids);
        }
        $posts = $posts->orderBy(Post::CREATED_AT, 'desc')->paginate();
        return $posts;
    }

    /**
     * 記事詳細
     * @param string $id
     * @return Post
     */
    public function show(string $id)
    {
        $post = Post::where('id', $id)->with(['category', 'comments', 'tags'])->first();

        return $post ?? abort(404);
    }

    /**
     * コメント投稿
     * @param Post $post
     * @param StoreComment $request
     * @return \Illuminate\Http\Response
     */
    public function addComment(Post $post, StoreComment $request)
    {
        $comment = new Comment();
        $comment->body = $request->get('body');
        $comment->user_name = $request->get('user_name');
        $comment->user_link = $request->get('user_link');
        $post->comments()->save($comment);

        // リレーションをロードするためにコメントを取得しなおす
        $new_comment = Comment::where('id', $comment->id)->first();

        return response($new_comment, 201);
    }

    private function getAlterThumbnail($category)
    {
        if($category == 1){
            return "/storage/images/work.png";
        }else{
            return "/storage/images/column.png";
        }
    }
}
