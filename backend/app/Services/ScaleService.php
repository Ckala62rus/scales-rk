<?php

namespace App\Services;

use App\Contracts\Scale\ScaleRepositoryInterface;
use App\Contracts\Scale\ScaleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScaleService implements ScaleServiceInterface
{
    /**
     * @param ScaleRepositoryInterface $scaleRepository
     */
    public function __construct(
        private ScaleRepositoryInterface $scaleRepository,
    ){}

    /**
     * Get all scale with pagination and relation
     *
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllScalesWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->scaleRepository
            ->getQuery();

        return $this
            ->scaleRepository
            ->getAllScalesWithPagination($query, $limit);
    }

    /**
     * Get all scale collection without pagination
     *
     * @param array $filter
     * @return Collection
     */
    public function getAllScalesCollection(array $filter): Collection
    {
        $query = $this
            ->scaleRepository
            ->getQuery();

//        $query = $this
//            ->scaleRepository
//            ->withScaleRelation($query, ["scales_weight"]);

        return $this
            ->scaleRepository
            ->getAllScalesCollection($query);
    }

    /**
     * Create scale entity and return model
     *
     * @param array $data
     * @return Model
     */
    public function createScale(array $data): Model
    {
        $query = $this
            ->scaleRepository
            ->getQuery();

        return $this
            ->scaleRepository
            ->createScale($query, $data);
    }

    /**
     * Get scale entity by id
     *
     * @param int $id
     * @return Model|null
     */
    public function getScaleById(int $id): ?Model
    {
        $query = $this
            ->scaleRepository
            ->getQuery();

        $query = $this
            ->scaleRepository
            ->withScaleRelation($query, ["scales_weight"]);

        return $this
            ->scaleRepository
            ->getScaleById($query, $id);
    }

    /**
     * Update Scale by id
     *
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateScale(int $id, array $data): ?Model
    {
        $entity = $this->getScaleById($id);

        if (!$entity) {
            throw new NotFoundHttpException();
        }

        $query = $this
            ->scaleRepository
            ->getQuery();

        return $this
            ->scaleRepository
            ->updateScale($query, $id, $data);
    }

    /**
     * Delete Scale by id
     *
     * @param int $id
     * @return bool
     */
    public function deleteScale(int $id): bool
    {
        $query = $this
            ->scaleRepository
            ->getQuery();

        return $this
            ->scaleRepository
            ->deleteScale($query, $id);
    }
}
