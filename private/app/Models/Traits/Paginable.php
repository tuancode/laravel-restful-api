<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Paginable
{
    /**
     * @param Builder $query
     * @param array   $pages
     *
     * @return \Illuminate\Contracts\Pagination\Paginator|Builder
     */
    public function addPagination(Builder $query, array $pages = [])
    {
        $page = $pages['number'] ?? null;
        $perPage = $pages['size'] ?? $this->getPerPage();

        $query = $query->paginate($perPage, ['*'], 'page[number]', $page);

        foreach ($pages as $paramKey => $paramValue) {
            $query->appends("page[$paramKey]", $paramValue);
        }

        return $query;
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    abstract public function getPerPage();
}