<?php

namespace App\Http\Resources;

use App\Models\People;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class CommentsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => CommentResource::collection($this->collection),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request): array
    {
        $included  = $this->collection->map(
            function ($article) {
                return $article->author;
            }
        )->unique();
        return [
            'links'    => [
                'self' => route('comments.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    /**
     * @param Collection $included
     *
     * @return mixed
     */
    private function withIncluded(Collection $included): array
    {
        return $included->map(function ($include) {
            if ($include instanceof People) {
                return new PeopleResource($include);
            }
        });
    }
}
