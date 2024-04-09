<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface EquipmentRepositoryInterface
{
    public function getAllEquipmentsWithPagination(int $limit): LengthAwarePaginator;
    public function getAllEquipmentsCollection(): Collection;
    public function createEquipment(array $data): Model;
    public function getEquipmentById(int $id): ?Model;
    public function updateEquipment(int $id, array $data): ?Model;
    public function deleteEquipment(int $id): bool;
}
