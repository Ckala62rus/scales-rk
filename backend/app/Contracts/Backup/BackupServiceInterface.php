<?php

namespace App\Contracts\Backup;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupServiceInterface
{
    public function getAllBackupsWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllBackupsCollection(array $filter): Collection;
    public function createBackup(array $data): Model;
    public function getBackupById(int $id): ?Model;
    public function updateBackup(int $id, array $data): ?Model;
    public function deleteBackup(int $id): bool;
}
