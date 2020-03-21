<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCommentApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_コメントを追加できる()
    {
        $this->withoutExceptionHandling();
        
        factory(Post::class)->create();
        $post = Post::first();

        $body = 'sample content';
        $user_name = 'user_name';
        $user_link = 'user_link';

        $response = $this->json('POST', route('post.comment', [
                'post' => $post->id,
                'body' => $body,
                'user_name' => $user_name,
                'user_link' => $user_link
            ]));

        $comments = $post->comments()->get();

        $response->assertStatus(201)
            // JSONフォーマットが期待通りであること
            ->assertJsonFragment([
                "user_name" => $user_name,
                "user_link" => $user_link,
                "body" => $body,
            ]);

        // DBにコメントが1件登録されていること
        $this->assertEquals(1, $comments->count());
        // 内容がAPIでリクエストしたものであること
        $this->assertEquals($body, $comments[0]->body);
    }
}
