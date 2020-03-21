<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tagmap;
use Faker\Generator as Faker;

$factory->define(Tagmap::class, function (Faker $faker) {
    return [
        'post_id' => fn() => factory(App\Post::class)->create()->id,
        'tag_id' => fn() => factory(App\Tag::class)->create()->id,
    ];
});
