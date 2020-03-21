<?php

namespace Tests\Feature;

use App\Post;
use App\Tag;
use App\Tagmap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        $this->withoutExceptionHandling();
        // 5つの記事データを生成する
        factory(Post::class, 3)->create();

        $response = $this->json('GET', route('post.index'));

        // 生成した記事データを作成日降順で取得
        $posts = Post::with(['category'])->orderBy('created_at', 'desc')->get();

        // data項目の期待値
        $expected_data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'thumbnail' => $post->thumbnail,
                'abstract' => $post->abstract,
                'body' => $post->body,
                'category_id' => $post->category_id,
                'category' => [
                    'name' => $post->category->name,
                ],
                'tags' => [],
                'created_at' => $post->toArray()['created_at'],
                'updated_at' => $post->toArray()['updated_at']
            ];
        })
        ->all();

        $response->assertStatus(200)
            // レスポンスJSONのdata項目に含まれる要素が5つであること
            ->assertJsonCount(3, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
    
    /**
     * @test
     */
    public function should_指定カテゴリの記事を返却する()
    {
        // 3つの記事データを生成する
        factory(Post::class, 3)->create();

        $post = Post::with(['category'])->first();
        $response = $this->json('GET', route('post.index'), ['category' => $post->category->id]);

        // data項目の期待値
        $expected_data =
            [[
                'id' => $post->id,
                'title' => $post->title,
                'thumbnail' => $post->thumbnail,
                'abstract' => $post->abstract,
                'body' => $post->body,
                'category_id' => $post->category_id,
                'category' => [
                    'name' => $post->category->name,
                ],
                'tags' => [],
                'created_at' => $post->toArray()['created_at'],
                'updated_at' => $post->toArray()['updated_at']
            ]];

        $response->assertStatus(200)
            // レスポンスJSONのdata項目に含まれる要素が1つであること
            ->assertJsonCount(1, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
    
    /**
     * @test
     */
    public function should_指定タグの記事を返却する()
    {
        // 3つの記事データを生成する
        factory(Tagmap::class, 3)->create();

        $tag = Tag::all()->first();
        $tag_id = Tag::all()->where('name', $tag->name)->first()->id;
        $post_ids = Tagmap::all()->where('tag_id', $tag_id)->pluck('post_id');
        $post = Post::with(['category', 'tags'])->whereIn('id', $post_ids)->get();
        echo $post;
        $response = $this->json('GET', route('post.index'), ['tag' => $post->tags->first()->name]);

        // data項目の期待値
        $expected_data =
            [[
                'id' => $post->id,
                'title' => $post->title,
                'thumbnail' => $post->thumbnail,
                'abstract' => $post->abstract,
                'body' => $post->body,
                'category_id' => $post->category_id,
                'category' => [
                    'name' => $post->category->name,
                ],
                'tags' => [['name' => $post->tags->first()->name]],
                'created_at' => $post->toArray()['created_at'],
                'updated_at' => $post->toArray()['updated_at']
            ]];

        $response->assertStatus(200)
            // レスポンスJSONのdata項目に含まれる要素が1つであること
            ->assertJsonCount(1, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
    
    /**
     * @test
     */
    /*
    public function should_記事のタグを返却する()
    {
        $this->withoutExceptionHandling();

        // タグマップデータを生成する
        factory(Tagmap::class, 1)->create();
        
        // 生成した記事データを取得
        $post = Post::first();
        // 生成したタグデータを取得
        $tag = Tag::first();
        
        $response = $this->json('GET', route('post.index'));

        // data項目の期待値
        $expected_data = [
            'id' => $post->id,
            'title' => $post->title,
            'thumbnail' => $post->thumbnail,
            'abstract' => $post->abstract,
            'body' => $post->body,
            'category_id' => $post->category_id,
            'category' => [
                'name' => $post->category->name,
            ],
            'tags' => [
                ['name' => $tag->name],
            ]
        ];
        
        $response->assertStatus(200)
            // レスポンスJSONのdata項目に含まれる要素が1つであること
            ->assertJsonCount(1, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
    */
}
