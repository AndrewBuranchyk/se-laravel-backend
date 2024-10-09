<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Builder;

class LogSearch implements SearchInterface
{
    /**
     * Get search query for filtering of logs listing
     *
     * @param Builder $query
     * @param array $fields
     * @return Builder
     */
    public function getQuery(Builder $query, array $fields): Builder
    {
        if (empty($fields['search'])) {
            return $query;
        }

        $query->select('logs.*');

        $query->leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'logs.user_id');
        });

        $query->orWhere('logs.event', 'like', '%' . $fields['search'] . '%');
        $query->orWhere('logs.model', 'like', '%' . $fields['search'] . '%');
        $query->orWhere('users.name', 'like', '%' . $fields['search'] . '%');

        return $query;
    }
}
