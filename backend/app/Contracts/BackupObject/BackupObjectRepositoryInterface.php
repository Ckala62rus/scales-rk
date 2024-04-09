<?php

namespace App\Contracts\BackupObject;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupObjectRepositoryInterface
{
    public function getAllBackupObjectsWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllBackupObjectsCollection(Builder $query): Collection;
    public function createBackupObject(Builder $query, array $data): Model;
    public function getBackupObjectById(Builder $query, int $id): ?Model;
    public function updateBackupObject(Builder $query, int $id, array $data): ?Model;
    public function deleteBackupObject(Builder $query, int $id): bool;
    public function getQuery(): Builder;
}
