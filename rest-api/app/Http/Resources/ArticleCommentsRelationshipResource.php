<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCommentsRelationshipResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $article = $this->additional['article'];

        return [
            'data'  => CommentIdentifierResource::collection($this->collection),
            'links' => [
                'self'    => route('articles.relationships.comments', ['article' => $article->id]),
                'related' => route('articles.comments', ['article' => $article->id]),
            ],
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        return [
            'links' => [
                'self' => route('articles.index'),
            ],
        ];
    }
}
