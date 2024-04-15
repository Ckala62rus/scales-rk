<?php

namespace App\Repositories;

use App\Contracts\ScaleWeight\ScaleWeightRepositoryInterface;
use App\Models\ScaleWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ScaleWeightRepository extends BaseRepository implements ScaleWeightRepositoryInterface
{
    public function __construct()
    {
        $this->model = new ScaleWeight();
    }

    /**
     * Get all scale weight with pagination
     *
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllScalesWeightPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all scale weight collection
     *
     * @param Builder $query
     * @return Collection
     */
    public function getAllScalesWeightCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create new scale weight
     *
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createScaleWeight(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get scale weight by id or null if not exist
     *
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getScaleWeightById(Builder $query, int $id): ?Model
    {
        return $query->where('id', $id)->first();
    }

    /**
     * Update scale weight by id if exist model, else model not found return null
     *
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateScaleWeight(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete scales weight by id
     *
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteScaleWeight(Builder $query, int $id): bool
    {
        return $query->where('id', $id)->delete();
    }

    /**
     * Get query builder
     *
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this
            ->model
            ->newQuery();
    }

    /**
     * Set relation
     *
     * @param Builder $query
     * @param array $with
     * @return Builder
     */
    public function withScaleWeightRelation(Builder $query, array $with): Builder
    {
        return $query->with($with);
    }
}
