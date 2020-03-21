<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_画像ファイルがストレージに保存される()
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('dummy.jpg', 800, 800);
        $response = $this->json('POST', '/api/images', [
            'image' => $image,
        ]);
        $response->assertStatus(201);
        Storage::disk('public')->assertExists('upload/images/'.$image->hashName());
    }
}
