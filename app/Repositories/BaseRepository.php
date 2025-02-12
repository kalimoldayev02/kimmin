<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    abstract protected function getAll(
        array $select = ['*'],
        array $filters = [],
        array $orders = [],
        int   $limit = 15
    ): Collection;

    abstract protected function getAllPaginated(
        array $select = ['*'],
        array $relations = [],
        array $filters = [],
        array $orders = [],
        int   $page = 1,
        int $pageLimit = 15
    ): LengthAwarePaginator;

    abstract protected function applyFilters(Model $model, array $filters): void;

    abstract protected function applyRelations(Model $model, array $relations): void;

    protected function applyOrders(Model $model, array $orders): void
    {
        foreach ($orders as $key => $value) {
            $model->orderBy($key, $value);
        }
    }
}