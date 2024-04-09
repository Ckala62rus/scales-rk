<?php

namespace App\Repositories;

use App\Contracts\BackupTool\BackupToolRepositoryInterface;
use App\Models\BackupTool;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupToolRepository extends BaseRepository implements BackupToolRepositoryInterface
{
    public function __construct()
    {
        $this->model = new BackupTool();
    }

    /**
     * Get all backup object with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllBackupToolsWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all backup objects collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllBackupToolsCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create new backup tool
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createBackupTool(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get backup tool by id or return null
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getBackupToolById(Builder $query, int $id): ?Model
    {
        return $query->where('id', $id)->first();
    }

    /**
     * Update backup tool by id if exist model, else model not found return null
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupTool(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete backup tool by id and return bool
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteBackupTool(Builder $query, int $id): bool
    {
        return $query->where('id', $id)->delete();
    }

    /**
     * Get query builder
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->model->newQuery();
    }
}
