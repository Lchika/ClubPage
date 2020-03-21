<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class PostSubmitApiTest extends TestCase
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
    public function should_記事を投稿できる()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), [
                'id' => "test_id",
                'title' => "test_title",
                'category_id' => 0,
                'body' => "test_body",
                'tags' => [["text" => "tag1"], ["text" => "tag2"]],
            ]);

        // レスポンスが201(CREATED)であること
        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function should_idがない場合はエラーとする()
    {
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), [
                'title' => "test_title",
                'category_id' => 0,
                'body' => "test_body",
            ]);

        $response->assertStatus(500);
    }
    
    /**
     * @test
     */
    public function should_titleがない場合はエラーとする()
    {
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), [
                'id' => "test_id",
                'category_id' => 0,
                'body' => "test_body",
            ]);

        $response->assertStatus(422);
    }
    
    /**
     * @test
     */
    public function should_category_idがない場合はエラーとする()
    {
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), [
                'id' => "test_id",
                'title' => "test_title",
                'body' => "test_body",
            ]);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_bodyがない場合はエラーとする()
    {
        $response = $this->actingAs($this->user)->json('POST', route('post.create'), [
                'id' => "test_id",
                'title' => "test_title",
                'category_id' => 0,
            ]);

        $response->assertStatus(422);
    }
}
