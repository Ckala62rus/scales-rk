<?php

namespace App\Services;

use App\Contracts\ScaleWeight\ScaleWeightRepositoryInterface;
use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ScaleWeightService implements ScaleWeightServiceInterface
{
    public function __construct(
        private ScaleWeightRepositoryInterface $weightRepository
    ){}

    /**
     * Get all scale weight with pagination
     *
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllScalesWeightWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->weightRepository
            ->getQuery();

        if ($filter["scale_id"]) {
            $query = $query->where("scale_id", $filter["scale_id"]);
        }

        return $this
            ->weightRepository
            ->getAllScalesWeightPagination($query, $limit);
    }

    /**
     * Get all weight collection
     *
     * @param array $filter
     * @return Collection
     */
    public function getAllScalesWeightCollection(array $filter): Collection
    {
        $query = $this
            ->weightRepository
            ->getQuery();

        if ($filter["scale_id"]) {
            $query = $query->where("scale_id", $filter["scale_id"]);
        }

        return $this
            ->weightRepository
            ->getAllScalesWeightCollection($query);
    }

    /**
     * Create scale weight and return model
     *
     * @param array $data
     * @return Model
     */
    public function createScaleWeight(array $data): Model
    {
        $query = $this
            ->weightRepository
            ->getQuery();

        return $this
            ->weightRepository
            ->createScaleWeight($query, $data);
    }

    /**
     * Get scale weight by id
     *
     * @param int $id
     * @return Model|null
     */
    public function getScaleWeightById(int $id): ?Model
    {
        $query = $this
            ->weightRepository
            ->getQuery();

        return $this
            ->weightRepository
            ->getScaleWeightById($query, $id);
    }

    /**
     * Update scale weight by id
     *
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateScaleWeight(int $id, array $data): ?Model
    {
        $query = $this
            ->weightRepository
            ->getQuery();

        return $this
            ->weightRepository
            ->updateScaleWeight($query, $id, $data);
    }

    /**
     * Delete scale weight by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteScaleWeight(int $id): bool
    {
        $query = $this
            ->weightRepository
            ->getQuery();

        return $this
            ->weightRepository
            ->deleteScaleWeight($query, $id);
    }
}
