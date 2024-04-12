<?php

namespace App\Contracts\Scale;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ScaleRepositoryInterface
{
    public function getAllScalesWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllScalesCollection(Builder $query): Collection;
    public function createScale(Builder $query, array $data): Model;
    public function getScaleById(Builder $query, int $id): ?Model;
    public function updateScale(Builder $query, int $id, array $data): ?Model;
    public function deleteScale(Builder $query, int $id): bool;
    public function getQuery(): Builder;
    public function withScaleRelation(Builder $query, array $with): Builder;
}
