<?php

namespace App\Repositories;

use App\Contracts\DeviceRepositoryInterface;
use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Device();
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
     * Get all devices with pagination
     * @param Builder $query
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllDevicesWithPagination(Builder $query, int $limit): LengthAwarePaginator
    {
        return $query->paginate($limit);
    }

    /**
     * Get all devices collection
     * @param Builder $query
     * @return Collection
     */
    public function getAllDevicesCollection(Builder $query): Collection
    {
        return $query->get();
    }

    /**
     * Create device
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createDevice(Builder $query, array $data): Model
    {
        return $query->create($data);
    }

    /**
     * Get device by id
     * @param Builder $query
     * @param int $id
     * @return Model|null
     */
    public function getDeviceById(Builder $query, int $id): ?Model
    {
        return $query->where('id', $id)->first();
    }

    /**
     * Update device by id
     * @param Builder $query
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateDevice(Builder $query, int $id, array $data): ?Model
    {
        $model = $query->where('id', $id)->first();
        if (!$model) {
            return null;
        }
        $model->update($data);
        return $model;
    }

    /**
     * Delete device by id
     * @param Builder $query
     * @param int $id
     * @return bool
     */
    public function deleteDevice(Builder $query, int $id): bool
    {
        return $query
            ->where('id', $id)
            ->delete();
    }

    /**
     * Set relations
     * @param Builder $query
     * @param array $with
     * @return Builder
     */
    public function withDeviceRelation(Builder $query, array $with): Builder
    {
        return $query->with($with);
    }
}
