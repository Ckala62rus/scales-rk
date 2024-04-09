<?php

namespace App\Services;

use App\Contracts\InternetServiceProvider\InternetServiceProviderRepositoryInterface;
use App\Contracts\InternetServiceProvider\InternetServiceProviderServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class InternetServiceProviderService implements InternetServiceProviderServiceInterface
{
    /**
     * @param InternetServiceProviderRepositoryInterface $internetServiceProviderRepository
     */
    public function __construct(
        private InternetServiceProviderRepositoryInterface $internetServiceProviderRepository
    ){}

    /**
     * Get all internet service providers with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllInternetServiceProvidersWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->internetServiceProviderRepository
            ->getQuery();

        $query = $this->setFilterForSearch($query, $filter);

        return $this
            ->internetServiceProviderRepository
            ->getAllInternetServiceProvidersWithPagination($query, $limit);
    }

    /**
     * Get all internet service provider collection
     * @param array $filter
     * @return Collection
     */
    public function getAllInternetServiceProvidersCollection(array $filter): Collection
    {
        $query = $this
            ->internetServiceProviderRepository
            ->getQuery();

        return $this
            ->internetServiceProviderRepository
            ->getAllInternetServiceProvidersCollection($query);
    }

    /**
     * Create internet service provider and return created model
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function createInternetServiceProvider(array $data): Model
    {
        $query = $this
            ->internetServiceProviderRepository
            ->getQuery();

        if (!Auth::user())
        {
            throw new Exception('User not authenticated! Method -> createInternetServiceProvider');
        }

        $data['user_id'] = Auth::user()->id;

        $query = $this
            ->internetServiceProviderRepository
            ->relationsInternetServiceProvider($query, [
                'user',
                'organization',
                'channel_type',
                'internet_speed',
            ]);

        return $this
            ->internetServiceProviderRepository
            ->createInternetServiceProvider($query, $data);
    }

    /**
     * Get internet service provider entity and return model or null if not exist
     * @param int $id
     * @return Model|null
     */
    public function getInternetServiceProviderById(int $id): ?Model
    {
        $query = $this
            ->internetServiceProviderRepository
            ->getQuery();

        $query = $this
            ->internetServiceProviderRepository
            ->relationsInternetServiceProvider($query, [
                'user',
                'organization',
                'channel_type',
                'internet_speed',
            ]);

        return $this
            ->internetServiceProviderRepository
            ->getInternetServiceProviderById($query, $id);
    }

    /**
     * Update internet service provider by id and return updated model
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateInternetServiceProvider(int $id, array $data): ?Model
    {
        $query = $this
            ->internetServiceProviderRepository
            ->getQuery();

        return $this
            ->internetServiceProviderRepository
            ->updateInternetServiceProvider($query, $id, $data);
    }

    /**
     * Delete internet service provider by id
     * @param int $id
     * @return bool
     */
    public function deleteInternetServiceProvider(int $id): bool
    {
        $query = $this
            ->internetServiceProviderRepository
            ->getQuery();

        return $this
            ->internetServiceProviderRepository
            ->deleteInternetServiceProvider($query, $id);
    }

    /**
     * Set filter and return query builder
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
    private function setFilterForSearch(Builder $query, array $filter): Builder
    {
        if(isset($filter['organization_id']) && $filter['organization_id'] != 0) {
            $query = $query->where('organization_id', $filter['organization_id']);
        }

        if(isset($filter['internet_speed_id']) && $filter['internet_speed_id'] != 0) {
            $query = $query->where('internet_speed_id', $filter['internet_speed_id']);
        }

        if(isset($filter['channel_type_id']) && $filter['channel_type_id'] != 0) {
            $query = $query->where('channel_type_id', $filter['channel_type_id']);
        }

        if(isset($filter['static_ip_address']) && $filter['static_ip_address'] != 0) {
            $query = $query->where('static_ip_address', 'LIKE', '%' . $filter['static_ip_address'] . '%');
        }

        if(isset($filter['cost']) && $filter['cost'] != 0) {
            $query = $query->where('cost', 'LIKE', '%' . $filter['cost'] . '%');
        }

        if(isset($filter['comment']) && $filter['comment'] != 0) {
            $query = $query->where('comment', 'LIKE', '%' . $filter['comment'] . '%');
        }

        return $query;
    }
}
