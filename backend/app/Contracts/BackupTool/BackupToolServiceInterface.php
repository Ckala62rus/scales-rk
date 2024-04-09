<?php

namespace App\Contracts\BackupTool;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupToolServiceInterface
{
    public function getAllBackupToolsWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllBackupToolsCollection(array $filter): Collection;
    public function createBackupTool(array $data): Model;
    public function getBackupToolById(int $id): ?Model;
    public function updateBackupTool(int $id, array $data): ?Model;
    public function deleteBackupTool(int $id): bool;
}
