<?php

namespace App\Repositories;

use App\Contracts\BackupPriority\BackupPriorityRepositoryInterface;
use App\Models\BackupPriority;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupPriorityRepository extends BaseRepository implements BackupPriorityRepositoryInterface
{
    public function __construct()
    {
        $this->model = new BackupPriority();
    }

    /**
     * Get all backup priorities with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllBackupPrioritiesWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get al backup priorities collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllBackupPrioritiesCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create new backup priority
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createBackupPriority(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get backup priority by id
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getBackupPriorityById(Builder $query, int $id): ?Model
    {
        return $query
            ->where('id', $id)
            ->first();
    }

    /**
     * Update backup priority entity by id
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupPriority(Builder $query, int $id, array $data): ?Model
    {
        $model = $query
            ->where('id', $id)
            ->first();

        if (!$model)
        {
            return null;
        }

        $model->update($data);
        return $model;
    }

    /**
     * Delete backup priority entity by id
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteBackupPriority(Builder $query, int $id): bool
    {
        return $query
            ->where('id', $id)
            ->delete();
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
