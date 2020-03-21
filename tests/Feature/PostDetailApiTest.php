<?php

namespace Tests\Feature;

use App\Post;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostDetailApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        factory(Post::class)->create()->each(function ($post) {
            $post->comments()->saveMany(factory(Comment::class, 3)->make());
        });
        $post = Post::first();

        $response = $this->json('GET', route('post.show', [
            'id' => $post->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'category' => [
                    'name' => $post->category->name,
                ],
                'comments' => $post->comments
                    ->sortByDesc('id')
                    ->map(function ($comment) {
                        return [
                            'user_name' => $comment->user_name,
                            'user_link' => $comment->user_link,
                            'body' => $comment->body,
                        ];
                    })
                    ->all(),
            ]);
    }
}
