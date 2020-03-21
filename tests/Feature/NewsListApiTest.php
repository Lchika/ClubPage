<?php

namespace Tests\Feature;

use App\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        $this->withoutExceptionHandling();
        // ニュースデータを生成する
        factory(News::class, 3)->create();

        $response = $this->json('GET', route('news.index'));

        // 生成したニュースデータを日付降順で取得
        $newsList = News::orderBy('date', 'desc')->get();

        // data項目の期待値
        $expected_data = $newsList->map(function ($news) {
            return [
                'date' => $news->date,
                'body' => $news->body,
            ];
        })
        ->all();

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment(['data' => $expected_data]);
    }
    
    /**
     * @test
     */
    public function should_正しい個数のデータを返却する()
    {
        $this->withoutExceptionHandling();
        $news_num = 5;
        // ニュースデータを生成する
        factory(News::class, 10)->create();

        $response = $this->json('GET', route('news.index'), ['quantity' => $news_num]);

        // 生成したニュースデータを日付降順で取得
        $newsList = News::orderBy('date', 'desc')->take($news_num)->get();

        // data項目の期待値
        $expected_data = $newsList->map(function ($news) {
            return [
                'date' => $news->date,
                'body' => $news->body,
            ];
        })
        ->all();

        $response->assertStatus(200)
            ->assertJsonCount($news_num, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment(['data' => $expected_data]);
    }
}
