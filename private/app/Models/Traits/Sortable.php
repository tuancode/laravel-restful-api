<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    /**
     * @param Builder     $query
     * @param null|string $sort
     */
    public function addSorts(Builder $query, ?string $sort): void
    {
        if (!$sort) {
            return;
        }

        $sorts = explode(',', $sort);

        foreach ($sorts as $sortColumn) {
            $sortDir = starts_with($sortColumn, '-') ? 'desc' : 'asc';
            $sortColumn = ltrim($sortColumn, '-');

            $query->orderBy($sortColumn, $sortDir);
        }
    }
}