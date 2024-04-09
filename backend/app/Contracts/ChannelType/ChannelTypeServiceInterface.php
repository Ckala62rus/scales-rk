<?php

namespace App\Contracts\ChannelType;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ChannelTypeServiceInterface
{
    public function getAllChannelTypesWithPagination(int $limit, array $filter): LengthAwarePaginator;
    public function getAllChannelTypesCollection(array $filter): Collection;
    public function createChannelType(array $data): Model;
    public function getChannelTypeById(int $id): ?Model;
    public function updateChannelType(int $id, array $data): ?Model;
    public function deleteChannelType(int $id): bool;
}
