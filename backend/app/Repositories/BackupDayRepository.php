<?php

namespace App\Repositories;

use App\Contracts\Day\BackupDayRepositoryInterface;
use App\Models\BackupDay;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupDayRepository extends BaseRepository implements BackupDayRepositoryInterface
{
    public function __construct()
    {
        $this->model = new BackupDay();
    }

    /**
     * Get all day entities with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllBackupDaysWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all day entities collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllBackupDaysCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create day entity
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createBackupDay(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get day entity by id and return model or null
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getBackupDayById(Builder $query, int $id): ?Model
    {
        return $query
            ->where('id', $id)
            ->first();
    }

    /**
     * Update day entity by id or return null if not exist in database
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupDay(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete Day entity by id
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteBackupDay(Builder $query, int $id): bool
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
        return $this
            ->model
            ->newQuery();
    }
}
