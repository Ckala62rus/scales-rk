<?php

namespace App\Contracts\BackupObject;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupObjectServiceInterface
{
    public function getAllBackupObjectsWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllBackupObjectsCollection(array $filter): Collection;
    public function createBackupObject(array $data): Model;
    public function getBackupObjectById(int $id): ?Model;
    public function updateBackupObject(int $id, array $data): ?Model;
    public function deleteBackupObject(int $id): bool;
}
