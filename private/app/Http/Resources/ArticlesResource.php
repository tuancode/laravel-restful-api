<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\People;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * ArticleCollection
 */
class ArticlesResource extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return ArticleResource::collection($this->collection);
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
        $comments = $this->collection->flatMap(
            function ($article) {
                return $article->comments;
            }
        );
        $authors  = $this->collection->map(
            function ($article) {
                return $article->author;
            }
        );
        $included = $authors->merge($comments)->unique();

        return [
            'links'    => [
                'self' => route('articles.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    /**
     * @param Collection $included
     *
     * @return Collection
     */
    private function withIncluded(Collection $included): Collection
    {
        return $included->map(function ($include) {
            if ($include instanceof People) {
                return new PeopleResource($include);
            }
            if ($include instanceof Comment) {
                return new CommentResource($include);
            }
        });
    }
}
