<?php

use Faker\Generator as Faker;

$factory->define(
    \App\Models\Article::class, function (Faker $faker) {
    return [
        'author_id' => function () {
            return factory(\App\Models\People::class)->create()->id;
        },
        'title' => $faker->title
    ];
});
