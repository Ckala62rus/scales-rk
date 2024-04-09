<?php

namespace App\Services;

use App\Contracts\BackupObject\BackupObjectRepositoryInterface;
use App\Contracts\BackupObject\BackupObjectServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupObjectService implements BackupObjectServiceInterface
{
    /**
     * @param BackupObjectRepositoryInterface $backupObjectRepository
     */
    public function __construct(
        private BackupObjectRepositoryInterface $backupObjectRepository
    ){}

    /**
     * Get all BackupObject with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllBackupObjectsWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->backupObjectRepository
            ->getQuery();

        return $this
            ->backupObjectRepository
            ->getAllBackupObjectsWithPagination($query, $limit);
    }

    /**
     * Get all backup objects collection without pagination
     * @param array $filter
     * @return Collection
     */
    public function getAllBackupObjectsCollection(array $filter): Collection
    {
        $query = $this
            ->backupObjectRepository
            ->getQuery();

        return $this
            ->backupObjectRepository
            ->getAllBackupObjectsCollection($query);
    }

    /**
     * Create new backup object entity
     * @param array $data
     * @return Model
     */
    public function createBackupObject(array $data): Model
    {
        $query = $this
            ->backupObjectRepository
            ->getQuery();

        return $this
            ->backupObjectRepository
            ->createBackupObject($query, $data);
    }

    /**
     * Get backup object by id or return null if not found
     * @param int $id
     * @return Model|null
     */
    public function getBackupObjectById(int $id): ?Model
    {
        $query = $this
            ->backupObjectRepository
            ->getQuery();

        return $this
            ->backupObjectRepository
            ->getBackupObjectById($query, $id);
    }

    /**
     * Update backup object and return model or null if not found
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupObject(int $id, array $data): ?Model
    {
        $query = $this
            ->backupObjectRepository
            ->getQuery();

        return $this
            ->backupObjectRepository
            ->updateBackupObject($query, $id, $data);
    }

    /**
     * Delete backup object by id
     * @param int $id
     * @return bool
     */
    public function deleteBackupObject(int $id): bool
    {
        $query = $this
            ->backupObjectRepository
            ->getQuery();

        return $this
            ->backupObjectRepository
            ->deleteBackupObject($query, $id);
    }
}
