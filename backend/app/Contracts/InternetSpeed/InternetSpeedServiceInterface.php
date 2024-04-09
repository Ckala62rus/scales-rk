<?php

namespace App\Contracts\InternetSpeed;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface InternetSpeedServiceInterface
{
    public function getAllInternetSpeedsWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllInternetSpeedsCollection(array $filter): Collection;
    public function createInternetSpeed(array $data): Model;
    public function getInternetSpeedById(int $id): ?Model;
    public function updateInternetSpeed(int $id, array $data): ?Model;
    public function deleteInternetSpeed(int $id): bool;
}
