<?php

namespace App\Repositories;

use App\Contracts\ChannelType\ChannelTypeRepositoryInterface;
use App\Models\ChannelType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ChannelTypeRepository extends BaseRepository implements ChannelTypeRepositoryInterface
{
    public function __construct()
    {
        $this->model = new ChannelType();
    }

    /**
     * Get all channel types with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllChannelTypesWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all channel types collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllChannelTypesCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create channel type
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createChannelType(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get channel type by id
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getChannelTypeById(Builder $query, int $id): ?Model
    {
        return $query
            ->where('id', $id)
            ->first();
    }

    /**
     * Update channel type entity by id
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateChannelType(Builder $query, int $id, array $data): ?Model
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
     * Delete channel type entity by id
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteChannelType(Builder $query, int $id): bool
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
