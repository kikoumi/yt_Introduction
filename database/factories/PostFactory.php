<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    //Seederで実行したい内容をここにかく
    return [
        'user_id' => 1,
        'category_id' => 1,
        'title' => $faker->realText($faker->numberBetween(10,25)),
        'url' => $faker->url(),
        'description' => $faker->realText($faker->numberBetween(50,200)),
    ];
});
