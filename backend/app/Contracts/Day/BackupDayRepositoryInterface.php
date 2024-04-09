<?php

namespace App\Contracts\Day;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupDayRepositoryInterface
{
    public function getAllBackupDaysWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllBackupDaysCollection(Builder $query): Collection;
    public function createBackupDay(Builder $query, array $data): Model;
    public function getBackupDayById(Builder $query, int $id): ?Model;
    public function updateBackupDay(Builder $query, int $id, array $data): ?Model;
    public function deleteBackupDay(Builder $query, int $id): bool;
    public function getQuery(): Builder;
}
