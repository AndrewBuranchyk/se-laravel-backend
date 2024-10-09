<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Builder;

interface SearchInterface
{
    /**
     * Get search query for filtering of a resource listing
     *
     * @param Builder $query
     * @param array $fields
     * @return Builder
     */
    public function getQuery(Builder $query, array $fields): Builder;
}
