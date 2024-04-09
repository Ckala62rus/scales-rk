<?php

namespace App\Contracts\BackupPriority;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupPriorityRepositoryInterface
{
    public function getAllBackupPrioritiesWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllBackupPrioritiesCollection(Builder $query): Collection;
    public function createBackupPriority(Builder $query, array $data): Model;
    public function getBackupPriorityById(Builder $query, int $id): ?Model;
    public function updateBackupPriority(Builder $query, int $id, array $data): ?Model;
    public function deleteBackupPriority(Builder $query, int $id): bool;
    public function getQuery(): Builder;
}
