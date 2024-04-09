<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface DeviceRepositoryInterface
{
    public function getAllDevicesWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllDevicesCollection(Builder $query): Collection;
    public function createDevice(Builder $query, array $data): Model;
    public function getDeviceById(Builder $query, int $id): ?Model;
    public function updateDevice(Builder $query, int $id, array $data): ?Model;
    public function deleteDevice(Builder $query, int $id): bool;
    public function getQuery(): Builder;
    public function withDeviceRelation(Builder $query, array $with);
}
