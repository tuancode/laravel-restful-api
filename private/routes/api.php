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

Route::post('register', 'AuthController@register');

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', 'UserController');
    Route::apiResource('articles', 'ArticleController');
    Route::apiResource('authors', 'AuthorController');
    Route::apiResource('comments', 'CommentController');
});

Route::get(
    'articles/{article}/relationships/author',
    [
        'uses' => 'ArticleRelationshipController@author',
        'as' => 'articles.relationships.author',
    ]
);
Route::get(
    'articles/{article}/author',
    [
        'uses' => 'ArticleRelationshipController@author',
        'as' => 'articles.author',
    ]
);
Route::get(
    'articles/{article}/relationships/comments',
    [
        'uses' => 'ArticleRelationshipController@comments',
        'as' => 'articles.relationships.comments',
    ]
);
Route::get(
    'articles/{article}/comments',
    [
        'uses' => 'ArticleRelationshipController@comments',
        'as' => 'articles.comments',
    ]
);