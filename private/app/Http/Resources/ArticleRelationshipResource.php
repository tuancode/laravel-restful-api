<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ArticleRelationshipResource
 */
class ArticleRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'author' => [
                'links' => [
                    'self' => route('articles.relationships.author', ['article' => $this->id]),
                    'related' => route('articles.author', ['article' => $this->id]),
                ],
                'data' => new AuthorIdentifierResource($this->author),
            ],
            'comments' => (new ArticleCommentsRelationshipResource($this->comments))->additional(['article' => $this]),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        return [
            'links' => [
                'self' => route('articles.index'),
            ]
        ];
    }
}
