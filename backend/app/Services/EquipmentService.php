<?php

namespace App\Services;

use App\Contracts\EquipmentRepositoryInterface;
use App\Contracts\EquipmentServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EquipmentService implements EquipmentServiceInterface
{
    private EquipmentRepositoryInterface $equipmentRepository;

    public function __construct(EquipmentRepositoryInterface $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    /**
     * Get all equipments with pagination
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllEquipmentsWithPagination(int $limit): LengthAwarePaginator
    {
        return $this->equipmentRepository->getAllEquipmentsWithPagination($limit);
    }

    /**
     * Get all equipments collection
     * @return Collection
     */
    public function getAllEquipmentsCollection(): Collection
    {
        return $this->equipmentRepository->getAllEquipmentsCollection();
    }

    /**
     * Create equipment
     * @param array $data
     * @return Model
     */
    public function createEquipment(array $data): Model
    {
        return $this->equipmentRepository->createEquipment($data);
    }

    /**
     * Get equipment by id
     * @param int $id
     * @return Model|null
     */
    public function getEquipmentById(int $id): ?Model
    {
        return $this->equipmentRepository->getEquipmentById($id);
    }

    /**
     * Update equipment by id
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateEquipment(int $id, array $data): ?Model
    {
        return $this->equipmentRepository->updateEquipment($id, $data);
    }

    /**
     * Delete equipment by id
     * @param int $id
     * @return bool
     */
    public function deleteEquipment(int $id): bool
    {
        return $this->equipmentRepository->deleteEquipment($id);
    }
}
