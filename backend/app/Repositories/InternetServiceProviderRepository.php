<?php

namespace App\Repositories;

use App\Contracts\InternetServiceProvider\InternetServiceProviderRepositoryInterface;
use App\Models\InternetServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class InternetServiceProviderRepository extends BaseRepository implements InternetServiceProviderRepositoryInterface
{
    public function __construct()
    {
        $this->model = new InternetServiceProvider();
    }

    /**
     * Get internet service provider with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllInternetServiceProvidersWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all internet service provider collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllInternetServiceProvidersCollection(Builder $query): Collection
    {
        return  $query->get();
    }

    /**
     * Create internet service provider entity and return model
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createInternetServiceProvider(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get internet service provider entity by id and return model or null if not exist
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getInternetServiceProviderById(Builder $query, int $id): ?Model
    {
        return $query
            ->where('id', $id)
            ->first();
    }

    /**
     * Update internet service provider by id and return updated model
     * or return null if model not exist in database
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateInternetServiceProvider(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteInternetServiceProvider(Builder $query, int $id): bool
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

    /**
     * Set relationship
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public function relationsInternetServiceProvider(Builder $query, array $data): Builder
    {
        return $query->with($data);
    }
}
