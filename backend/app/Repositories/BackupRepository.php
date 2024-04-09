<?php

namespace App\Repositories;

use App\Contracts\Backup\BackupRepositoryInterface;
use App\Models\Backup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupRepository extends  BaseRepository implements BackupRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Backup();
    }

    /**
     * Get query
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get all backup with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllBackupsWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all backup collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllBackupsCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create new backup
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createBackup(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get backup by id or null if not exist
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getBackupById(Builder $query, int $id): ?Model
    {
        return $query->where('id', $id)->first();
    }

    /**
     * Update backup by id if exist model, else model not found return null
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackup(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete backup by id
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteBackup(Builder $query, int $id): bool
    {
        return $query->where('id', $id)->delete();
    }

    /**
     * Set relations
     * @param Builder $query
     * @param array $with
     * @return Builder
     */
    public function withBackupRelation(Builder $query, array $with): Builder
    {
        return $query->with($with);
    }
}
