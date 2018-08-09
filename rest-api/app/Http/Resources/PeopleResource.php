<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PeopleResource
 */
class PeopleResource extends JsonResource
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
            'type'       => 'people',
            'id'         => (string) $this->id,
            'attributes' => [
                'first-name' => $this->first_name,
                'last-name'  => $this->last_name,
                'twitter'    => $this->twitter,
            ],
            'links'      => [
                'self' => route('authors.show', ['authors' => $this->id]),
            ],
        ];
    }
}
