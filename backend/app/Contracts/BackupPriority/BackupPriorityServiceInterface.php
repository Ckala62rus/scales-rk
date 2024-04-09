<?php

namespace App\Contracts\BackupPriority;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupPriorityServiceInterface
{
    public function getAllBackupPrioritiesWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllBackupPrioritiesCollection(array $filter): Collection;
    public function createBackupPriority(array $data): Model;
    public function getBackupPriorityById(int $id): ?Model;
    public function updateBackupPriority(int $id, array $data): ?Model;
    public function deleteBackupPriority(int $id): bool;
}
