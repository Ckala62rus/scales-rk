<?php

namespace App\Repositories;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationRepository extends BaseRepository implements OrganizationRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Organization();
    }

    /**
     * Get all organization with pagination
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllOrganizationsWithPagination(int $limit): LengthAwarePaginator
    {
        return $this->getAllWithPagination($limit);
    }

    /**
     * Get all organization collection
     * @return Collection
     */
    public function getAllOrganizationsCollection(): Collection
    {
        return $this->getAll();
    }

    /**
     * Create organization
     * @param array $data
     * @return Model
     */
    public function createOrganization(array $data): Model
    {
        return $this->create($data);
    }

    /**
     * Get organization by id
     * @param int $id
     * @return Model|null
     */
    public function getOrganizationById(int $id): ?Model
    {
        return $this->getById($id);
    }

    /**
     * Update organization by id
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateOrganization(int $id, array $data): ?Model
    {
        return $this->update($id, $data);
    }

    /**
     * Delete organization by id
     * @param int $id
     * @return bool
     */
    public function deleteOrganization(int $id): bool
    {
        return $this->delete($id);
    }
}
