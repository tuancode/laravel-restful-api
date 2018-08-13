<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\PeopleResource;

/**
 * ArticleRelationshipController
 */
class ArticleRelationshipController extends Controller
{
    /**
     * @param Article $article
     *
     * @return PeopleResource
     */
    public function author(Article $article): PeopleResource
    {
        return new PeopleResource($article->author());
    }

    /**
     * @param \App\Models\Article $article
     *
     * @return CommentsResource
     */
    public function comments(Article $article): CommentsResource
    {
        return new CommentsResource($article->comments());
    }
}
