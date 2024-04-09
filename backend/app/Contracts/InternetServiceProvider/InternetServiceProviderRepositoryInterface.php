<?php

namespace App\Contracts\InternetServiceProvider;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface InternetServiceProviderRepositoryInterface
{
    public function getAllInternetServiceProvidersWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllInternetServiceProvidersCollection(Builder $query): Collection;
    public function createInternetServiceProvider(Builder $query, array $data): Model;
    public function getInternetServiceProviderById(Builder $query, int $id): ?Model;
    public function updateInternetServiceProvider(Builder $query, int $id, array $data): ?Model;
    public function deleteInternetServiceProvider(Builder $query, int $id): bool;
    public function relationsInternetServiceProvider(Builder $query, array $data): Builder;
    public function getQuery(): Builder;
}
