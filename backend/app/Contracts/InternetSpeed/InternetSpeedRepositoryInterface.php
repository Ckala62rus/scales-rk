<?php

namespace App\Contracts\InternetSpeed;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface InternetSpeedRepositoryInterface
{
    public function getAllInternetSpeedsWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllInternetSpeedsCollection(Builder $query): Collection;
    public function createInternetSpeed(Builder $query, array $data): Model;
    public function getInternetSpeedById(Builder $query, int $id): ?Model;
    public function updateInternetSpeed(Builder $query, int $id, array $data): ?Model;
    public function deleteInternetSpeed(Builder $query, int $id): bool;
    public function getQuery(): Builder;
}
