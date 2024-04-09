<?php

namespace App\Contracts\Day;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupDayServiceInterface
{
    public function getAllBackupDaysWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllBackupDaysCollection(array $filter): Collection;
    public function createBackupDay(array $data): Model;
    public function getBackupDayById(int $id): ?Model;
    public function updateBackupDay(int $id, array $data): ?Model;
    public function deleteBackupDay(int $id): bool;
}
