<?php

namespace App\Services;

use App\Contracts\InternetSpeed\InternetSpeedRepositoryInterface;
use App\Contracts\InternetSpeed\InternetSpeedServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class InternetSpeedService implements InternetSpeedServiceInterface
{
    /**
     * @param InternetSpeedRepositoryInterface $internetSpeedRepository
     */
    public function __construct(
        private InternetSpeedRepositoryInterface $internetSpeedRepository
    ){}

    /**
     * Get all internet speed entities with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator.
     */
    public function getAllInternetSpeedsWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->internetSpeedRepository
            ->getQuery();

        return $this
            ->internetSpeedRepository
            ->getAllInternetSpeedsWithPagination($query, $limit);
    }

    /**
     * Get all internet speed entities with collection
     * @param array $filter
     * @return Collection
     */
    public function getAllInternetSpeedsCollection(array $filter): Collection
    {
        $query = $this
            ->internetSpeedRepository
            ->getQuery();

        return $this
            ->internetSpeedRepository
            ->getAllInternetSpeedsCollection($query);
    }

    /** Create new internet speed entity
     * @param array $data
     * @return Model
     */
    public function createInternetSpeed(array $data): Model
    {
        $query = $this
            ->internetSpeedRepository
            ->getQuery();

        return $this
            ->internetSpeedRepository
            ->createInternetSpeed($query, $data);
    }

    /**
     * Get internet speed entity by id
     * @param int $id
     * @return Model|null
     */
    public function getInternetSpeedById(int $id): ?Model
    {
        $query = $this
            ->internetSpeedRepository
            ->getQuery();

        return $this
            ->internetSpeedRepository
            ->getInternetSpeedById($query, $id);
    }

    /**
     * Update internet speed entity by id and return model or null if not exist
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateInternetSpeed(int $id, array $data): ?Model
    {
        $query = $this
            ->internetSpeedRepository
            ->getQuery();

        return $this
            ->internetSpeedRepository
            ->updateInternetSpeed($query, $id, $data);
    }

    /**
     * Delete internet speed entity by id
     * @param int $id
     * @return bool
     */
    public function deleteInternetSpeed(int $id): bool
    {
        $query = $this
            ->internetSpeedRepository
            ->getQuery();

        return $this
            ->internetSpeedRepository
            ->deleteInternetSpeed($query, $id);
    }
}
