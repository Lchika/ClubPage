<?php

namespace Tests\Feature;

use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagListApiTest extends TestCase
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
    public function should_正しい構造のJSONを返却する()
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

        $response = $this->json('GET', route('tag.index'));

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment(['data' => [['text' => 'tag1'], ['text' => 'tag2']]]);
    }
}