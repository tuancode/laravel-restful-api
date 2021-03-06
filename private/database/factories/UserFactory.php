<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function () {
    return [
        'name'  => 'user@example.net',
        'email' => 'user@example.net',
        'password' => bcrypt('user@example.net'),
        'remember_token' => str_random(10),
    ];
});
