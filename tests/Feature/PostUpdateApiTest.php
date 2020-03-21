<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Tag;

class PostUpdateApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    
    /**
     * @test
     */
    public function should_記事を更新できる()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->user)->json('POST', route('post.create'), [
                'id' => "test_id",
                'title' => "test_title",
                'category_id' => 0,
                'body' => "test_body",
            ]);
        
        $response = $this->actingAs($this->user)->json('PUT', route('post.update', ['id' => 'test_id']), [
                'title' => "test_title",
                'category_id' => 0,
                'body' => "test_body",
            ]);

        // レスポンスが200であること
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function should_記事のタグを更新できる()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs($this->user)->json('POST', route('post.create'), [
                'id' => "test_id",
                'title' => "test_title",
                'category_id' => 0,
                'body' => "test_body",
            ]);
        
        $response = $this->actingAs($this->user)->json('PUT', route('post.update', ['id' => 'test_id']), [
                'title' => "test_title",
                'category_id' => 0,
                'body' => "test_body",
                'tags' => [['text' => "test_tag1"]],
            ]);
        
        // タグテーブルに新規タグが登録されていること
        $this->assertDatabaseHas('tags', [
            'name' => 'test_tag1'
        ]);
        // タグマップテーブルに新規タグマップが登録されていること
        $this->assertDatabaseHas('tagmaps', [
            'post_id' => 'test_id',
            'tag_id' => Tag::where('name', 'test_tag1')->first()->id,
        ]);
        // レスポンスが200であること
        $response->assertStatus(200);
    }
}
