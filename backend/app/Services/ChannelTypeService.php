<?php

namespace App\Services;

use App\Contracts\ChannelType\ChannelTypeRepositoryInterface;
use App\Contracts\ChannelType\ChannelTypeServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ChannelTypeService implements ChannelTypeServiceInterface
{
    /**
     * @param ChannelTypeRepositoryInterface $channelTypeRepository
     */
    public function __construct(
        private ChannelTypeRepositoryInterface $channelTypeRepository
    ){}

    /**
     * Get all channel types with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllChannelTypesWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->channelTypeRepository
            ->getQuery();

        return $this
            ->channelTypeRepository
            ->getAllChannelTypesWithPagination($query, $limit);
    }

    /**
     * Get all channel types entities collection
     * @param array $filter
     * @return Collection
     */
    public function getAllChannelTypesCollection(array $filter): Collection
    {
        $query = $this
            ->channelTypeRepository
            ->getQuery();

        return $this
            ->channelTypeRepository
            ->getAllChannelTypesCollection($query);
    }

    /**
     * Create channel type entity
     * @param array $data
     * @return Model
     */
    public function createChannelType(array $data): Model
    {
        $query = $this
            ->channelTypeRepository
            ->getQuery();

        return $this
            ->channelTypeRepository
            ->createChannelType($query, $data);
    }

    /**
     * Get channel type entity by id
     * @param int $id
     * @return Model|null
     */
    public function getChannelTypeById(int $id): ?Model
    {
        $query = $this
            ->channelTypeRepository
            ->getQuery();

        return $this
            ->channelTypeRepository
            ->getChannelTypeById($query, $id);
    }

    /**
     * Update channel type entity by id and return model or null if not found
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateChannelType(int $id, array $data): ?Model
    {
        $query = $this
            ->channelTypeRepository
            ->getQuery();

        return $this
            ->channelTypeRepository
            ->updateChannelType($query, $id, $data);
    }

    /**
     * Delete channel type entity by id
     * @param int $id
     * @return bool
     */
    public function deleteChannelType(int $id): bool
    {
        $query = $this
            ->channelTypeRepository
            ->getQuery();

        return $this
            ->channelTypeRepository
            ->deleteChannelType($query, $id);
    }
}
