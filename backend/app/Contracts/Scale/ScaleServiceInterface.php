<?php

namespace App\Contracts\Scale;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ScaleServiceInterface
{
    public function getAllScalesWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllScalesCollection(array $filter): Collection;
    public function createScale(array $data): Model;
    public function getScaleById(int $id): ?Model;
    public function updateScale(int $id, array $data): ?Model;
    public function deleteScale(int $id): bool;
}
