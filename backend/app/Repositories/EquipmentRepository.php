<?php

namespace App\Repositories;

use App\Contracts\EquipmentRepositoryInterface;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EquipmentRepository extends  BaseRepository implements  EquipmentRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Equipment();
    }

    /**
     * Get all equipment with pagination
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllEquipmentsWithPagination(int $limit): LengthAwarePaginator
    {
        return $this->getAllWithPagination($limit);
    }

    /**
     * Get all equipments collection
     * @return Collection
     */
    public function getAllEquipmentsCollection(): Collection
    {
        return $this->getAll();
    }

    /**
     * Create equipment
     * @param array $data
     * @return Model
     */
    public function createEquipment(array $data): Model
    {
        return $this->create($data);
    }

    /**
     * Get equipment by id
     * @param int $id
     * @return Model|null
     */
    public function getEquipmentById(int $id): ?Model
    {
        return $this->getById($id);
    }

    /**
     * Update equipment by id
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateEquipment(int $id, array $data): ?Model
    {
        return $this->update($id, $data);
    }

    /**
     * Delete equipment by id and return (boolean)
     * @param int $id
     * @return bool
     */
    public function deleteEquipment(int $id): bool
    {
        return $this->delete($id);
    }
}
