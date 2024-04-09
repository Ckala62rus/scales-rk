<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrganizationServiceInterface
{
    public function getAllOrganizationsWithPagination(int $limit): LengthAwarePaginator;
    public function getAllOrganizationsCollection(): Collection;
    public function createOrganizations(array $data): Model;
    public function getOrganizationsById(int $id): ?Model;
    public function updateOrganizations(int $id, array $data): ?Model;
    public function deleteOrganizations(int $id): bool;
}
