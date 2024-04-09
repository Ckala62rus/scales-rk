<?php

namespace App\Contracts\BackupTool;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BackupToolRepositoryInterface
{
    public function getAllBackupToolsWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllBackupToolsCollection(Builder $query): Collection;
    public function createBackupTool(Builder $query, array $data): Model;
    public function getBackupToolById(Builder $query, int $id): ?Model;
    public function updateBackupTool(Builder $query, int $id, array $data): ?Model;
    public function deleteBackupTool(Builder $query, int $id): bool;
    public function getQuery(): Builder;
}
