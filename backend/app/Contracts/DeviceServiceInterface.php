<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface DeviceServiceInterface
{
    public function getAllDevicesWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllDevicesCollection(array $filter): Collection;
    public function createDevice(array $data): Model;
    public function getDeviceById(int $id): ?Model;
    public function updateDevice(int $id, array $data): ?Model;
    public function deleteDevice(int $id): bool;
}
