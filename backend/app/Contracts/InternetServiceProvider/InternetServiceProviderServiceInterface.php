<?php

namespace App\Contracts\InternetServiceProvider;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface InternetServiceProviderServiceInterface
{
    public function getAllInternetServiceProvidersWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllInternetServiceProvidersCollection(array $filter): Collection;
    public function createInternetServiceProvider(array $data): Model;
    public function getInternetServiceProviderById(int $id): ?Model;
    public function updateInternetServiceProvider(int $id, array $data): ?Model;
    public function deleteInternetServiceProvider(int $id): bool;
}
