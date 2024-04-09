<?php

namespace App\Contracts\ChannelType;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ChannelTypeRepositoryInterface
{
    public function getAllChannelTypesWithPagination(Builder $query, int $limit): LengthAwarePaginator;
    public function getAllChannelTypesCollection(Builder $query): Collection;
    public function createChannelType(Builder $query, array $data): Model;
    public function getChannelTypeById(Builder $query, int $id): ?Model;
    public function updateChannelType(Builder $query, int $id, array $data): ?Model;
    public function deleteChannelType(Builder $query, int $id): bool;
    public function getQuery(): Builder;
}
