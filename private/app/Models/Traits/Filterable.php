<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $query
     * @param array   $filters
     */
    public function addFilters(Builder $query, array $filters = []): void
    {
        foreach ($filters as $criteria => $value) {
            if (null !== $value) {
                $query->where($criteria, $value);
            }
        }
    }
}