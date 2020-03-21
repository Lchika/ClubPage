<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'id' => Str::random(12),
        'title' => Str::random(20),
        'category_id' => fn() => factory(App\Category::class)->create()->id,
        'body' => Str::random(200),
        'thumbnail' => Str::random(30),
        'abstract' => Str::random(50),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
