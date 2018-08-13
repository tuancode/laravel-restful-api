<?php

use Faker\Generator as Faker;

$factory->define(
    \App\Models\Comment::class, function (Faker $faker) {
    return [
        'article_id' => function () {
            return factory(\App\Models\Article::class)->create()->id;
        },
        'author_id' => function () {
            return factory(\App\Models\People::class)->create()->id;
        },
        'body' => $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});
