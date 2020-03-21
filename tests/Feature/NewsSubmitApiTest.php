<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Faker\Provider\DateTime;

class NewsSubmitApiTest extends TestCase
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
    public function should_ニュースを投稿できる()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->actingAs($this->user)->json('POST', route('news.create'), [
                'date' => DateTime::date(),
                'body' => "test_body",
            ]);

        // レスポンスが201(CREATED)であること
        $response->assertStatus(201);
    }
}
