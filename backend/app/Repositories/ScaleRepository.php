<?php

namespace App\Repositories;

use App\Contracts\Scale\ScaleRepositoryInterface;
use App\Models\Scale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ScaleRepository extends BaseRepository implements ScaleRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Scale();
    }

    /**
     * Get all scales with pagination
     *
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllScalesWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all scales collection
     *
     * @param Builder $query
     * @return Collection
     */
    public function getAllScalesCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create scale entity and return model
     *
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createScale(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get scale entity by id or null if model not found
     *
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getScaleById(Builder $query, int $id): ?Model
    {
        return $query->where('id', $id)->first();
    }

    /**
     * Update scale by id if exist model, else model not found return null
     *
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateScale(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete scale by id
     *
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteScale(Builder $query, int $id): bool
    {
        return $query->where('id', $id)->delete();
    }

    /**
     * Get query
     *
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Set relations
     *
     * @param Builder $query
     * @param array $with
     * @return Builder
     */
    public function withScaleRelation(Builder $query, array $with): Builder
    {
        return $query->with($with);
    }
}
