<?php

namespace App\Contracts\Backup;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupRepositoryInterface
{
    public function getAllBackupsWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllBackupsCollection(Builder $query): Collection;
    public function createBackup(Builder $query, array $data): Model;
    public function getBackupById(Builder $query, int $id): ?Model;
    public function updateBackup(Builder $query, int $id, array $data): ?Model;
    public function deleteBackup(Builder $query, int $id): bool;
    public function getQuery(): Builder;
    public function withBackupRelation(Builder $query, array $with): Builder;
}
