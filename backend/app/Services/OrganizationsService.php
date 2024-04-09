<?php

namespace App\Services;

use App\Contracts\OrganizationRepositoryInterface;
use App\Contracts\OrganizationServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizationsService implements OrganizationServiceInterface
{
    private OrganizationRepositoryInterface $organizationRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Get all organization with pagination
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllOrganizationsWithPagination(int $limit): LengthAwarePaginator
    {
        return $this->organizationRepository->getAllOrganizationsWithPagination($limit);
    }

    /**
     * Get all organization collection
     * @return Collection
     */
    public function getAllOrganizationsCollection(): Collection
    {
        return $this->organizationRepository->getAllOrganizationsCollection();
    }

    /**
     * Create organization and return model
     * @param array $data
     * @return Model
     */
    public function createOrganizations(array $data): Model
    {
        return $this->organizationRepository->createOrganization($data);
    }

    /**
     * Get organization by id and return model
     * @param int $id
     * @return Model|null
     */
    public function getOrganizationsById(int $id): ?Model
    {
        return $this->organizationRepository->getOrganizationById($id);
    }

    /**
     * Update organization by id and return model
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateOrganizations(int $id, array $data): ?Model
    {
        return $this->organizationRepository->updateOrganization($id, $data);
    }

    /**
     * Delete organization by id (return boolean)
     * @param int $id
     * @return bool
     */
    public function deleteOrganizations(int $id): bool
    {
        return $this->organizationRepository->deleteOrganization($id);
    }
}
