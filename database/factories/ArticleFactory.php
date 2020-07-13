<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'content' => $faker->paragraph,
        'tag' => $faker->word,
        'user_id' => create(User::class)
    ];
});
