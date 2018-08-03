<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('login', 'Auth\LoginController@login')->name('login');
Route::post('register', 'AuthController@register')->name('register');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('products', 'ProductController');
    Route::apiResource('users', 'UserController', [
        'where' => ['id' => '\d+']
    ]);
});