<?php

namespace App\Contracts\ScaleWeight;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ScaleWeightRepositoryInterface
{
    public function getAllScalesWeightPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllScalesWeightCollection(Builder $query): Collection;
    public function createScaleWeight(Builder $query, array $data): Model;
    public function getScaleWeightById(Builder $query, int $id): ?Model;
    public function updateScaleWeight(Builder $query, int $id, array $data): ?Model;
    public function deleteScaleWeight(Builder $query, int $id): bool;
    public function getQuery(): Builder;
    public function withScaleWeightRelation(Builder $query, array $with): Builder;
}
