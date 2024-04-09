<?php

namespace App\Services;

use App\Contracts\BackupPriority\BackupPriorityRepositoryInterface;
use App\Contracts\BackupPriority\BackupPriorityServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupPriorityService implements BackupPriorityServiceInterface
{
    /**
     * @param BackupPriorityRepositoryInterface $backupPriorityRepository
     */
    public function __construct(
        private BackupPriorityRepositoryInterface $backupPriorityRepository
    ){}

    /**
     * Get all backup priorities with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllBackupPrioritiesWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->backupPriorityRepository
            ->getQuery();

        return $this
            ->backupPriorityRepository
            ->getAllBackupPrioritiesWithPagination($query, $limit);
    }

    /**
     * Get all backup properties collection
     * @param array $filter
     * @return Collection
     */
    public function getAllBackupPrioritiesCollection(array $filter): Collection
    {
        $query = $this
            ->backupPriorityRepository
            ->getQuery();

        return $this
            ->backupPriorityRepository
            ->getAllBackupPrioritiesCollection($query);
    }

    /**
     * Create backup priority
     * @param array $data
     * @return Model
     */
    public function createBackupPriority(array $data): Model
    {
        $query = $this
            ->backupPriorityRepository
            ->getQuery();

        return $this
            ->backupPriorityRepository
            ->createBackupPriority($query, $data);
    }

    /**
     * Get backup priority by id and return entity or null
     * @param int $id
     * @return Model|null
     */
    public function getBackupPriorityById(int $id): ?Model
    {
        $query = $this
            ->backupPriorityRepository
            ->getQuery();

        return $this
            ->backupPriorityRepository
            ->getBackupPriorityById($query, $id);
    }

    /**
     * Update backup priority by id
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupPriority(int $id, array $data): ?Model
    {
        $query = $this
            ->backupPriorityRepository
            ->getQuery();

        return $this
            ->backupPriorityRepository
            ->updateBackupPriority($query, $id, $data);
    }

    /**
     * Delete backup priority
     * @param int $id
     * @return bool
     */
    public function deleteBackupPriority(int $id): bool
    {
        $query = $this
            ->backupPriorityRepository
            ->getQuery();

        return $this
            ->backupPriorityRepository
            ->deleteBackupPriority($query, $id);
    }
}
