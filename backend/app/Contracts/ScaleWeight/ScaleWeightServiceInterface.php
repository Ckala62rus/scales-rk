<?php

namespace App\Contracts\ScaleWeight;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ScaleWeightServiceInterface
{
    public function getAllScalesWeightWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllScalesWeightCollection(array $filter): Collection;
    public function createScaleWeight(array $data): Model;
    public function getScaleWeightById(int $id): ?Model;
    public function updateScaleWeight(int $id, array $data): ?Model;
    public function deleteScaleWeight(int $id): bool;
}
