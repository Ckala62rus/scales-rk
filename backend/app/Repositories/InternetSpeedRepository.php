<?php

namespace App\Repositories;

use App\Contracts\InternetSpeed\InternetSpeedRepositoryInterface;
use App\Models\InternetSpeed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class InternetSpeedRepository extends BaseRepository implements InternetSpeedRepositoryInterface
{
    public  function __construct()
    {
        $this->model = new InternetSpeed();
    }

    /**
     * Get all internet speed entities with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllInternetSpeedsWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all internet speed entities with pagination
     * @param Builder $query
     * @return Collection
     */
    public function getAllInternetSpeedsCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create new entity internet speed and return model
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createInternetSpeed(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get internet speed entity by id and return model or null
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getInternetSpeedById(Builder $query, int $id): ?Model
    {
        return $query
            ->where('id', $id)
            ->first();
    }

    /**
     * Update model by id and return updated internet speed
     * entity or return null if entity not found
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateInternetSpeed(Builder $query, int $id, array $data): ?Model
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
     * Delete internet speed entity by id and return bool
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteInternetSpeed(Builder $query, int $id): bool
    {
        return $query
            ->where('id', $id)
            ->delete();
    }

    /**
     * Get Builder
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this
            ->model
            ->newQuery();
    }
}
