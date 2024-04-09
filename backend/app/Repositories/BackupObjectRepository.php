<?php

namespace App\Repositories;

use App\Contracts\BackupObject\BackupObjectRepositoryInterface;
use App\Models\BackupObject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupObjectRepository extends BaseRepository implements BackupObjectRepositoryInterface
{
    public function __construct()
    {
        $this->model = new BackupObject();
    }

    /**
     * Get all backup object with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllBackupObjectsWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all backup objects collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllBackupObjectsCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create new backup object
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createBackupObject(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get backup object by id or return null
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getBackupObjectById(Builder $query, int $id): ?Model
    {
        return $query->where('id', $id)->first();
    }

    /**
     * Update backup object by id if exist model, else model not found return null
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupObject(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            throw new \InvalidArgumentException('the model wasnt found');
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete backup object by id and return bool
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteBackupObject(Builder $query, int $id): bool
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
