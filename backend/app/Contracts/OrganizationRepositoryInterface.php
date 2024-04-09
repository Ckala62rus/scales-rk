<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrganizationRepositoryInterface
{
    public function getAllOrganizationsWithPagination(int $limit): LengthAwarePaginator;
    public function getAllOrganizationsCollection(): Collection;
    public function createOrganization(array $data): Model;
    public function getOrganizationById(int $id): ?Model;
    public function updateOrganization(int $id, array $data): ?Model;
    public function deleteOrganization(int $id): bool;
}
