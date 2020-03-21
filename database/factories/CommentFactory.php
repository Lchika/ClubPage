<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => substr($faker->text, 0, 500),
        'user_name' => substr($faker->text, 0, 30),
        'user_link' => substr($faker->text, 0, 30)
    ];
});
