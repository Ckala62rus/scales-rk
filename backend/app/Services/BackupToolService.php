<?php

namespace App\Services;

use App\Contracts\BackupObject\BackupObjectRepositoryInterface;
use App\Contracts\BackupObject\BackupObjectServiceInterface;
use App\Contracts\BackupTool\BackupToolRepositoryInterface;
use App\Contracts\BackupTool\BackupToolServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupToolService implements BackupToolServiceInterface
{
    /**
     * @param BackupToolRepositoryInterface $backupToolRepository
     */
    public function __construct(
        private BackupToolRepositoryInterface $backupToolRepository
    ){}

    /**
     * Get all BackupTools with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllBackupToolsWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->backupToolRepository
            ->getQuery();

        return $this
            ->backupToolRepository
            ->getAllBackupToolsWithPagination($query, $limit);
    }

    /**
     * Get all backup tools collection without pagination
     * @param array $filter
     * @return Collection
     */
    public function getAllBackupToolsCollection(array $filter): Collection
    {
        $query = $this
            ->backupToolRepository
            ->getQuery();

        return $this
            ->backupToolRepository
            ->getAllBackupToolsCollection($query);
    }

    /**
     * Create new tool object entity
     * @param array $data
     * @return Model
     */
    public function createBackupTool(array $data): Model
    {
        $query = $this
            ->backupToolRepository
            ->getQuery();

        return $this
            ->backupToolRepository
            ->createBackupTool($query, $data);
    }

    /**
     * Get backup tool by id or return null if not found
     * @param int $id
     * @return Model|null
     */
    public function getBackupToolById(int $id): ?Model
    {
        $query = $this
            ->backupToolRepository
            ->getQuery();

        return $this
            ->backupToolRepository
            ->getBackupToolById($query, $id);
    }

    /**
     * Update backup tool and return model or null if not found
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupTool(int $id, array $data): ?Model
    {
        $query = $this
            ->backupToolRepository
            ->getQuery();

        return $this
            ->backupToolRepository
            ->updateBackupTool($query, $id, $data);
    }

    /**
     * Delete backup tool by id
     * @param int $id
     * @return bool
     */
    public function deleteBackupTool(int $id): bool
    {
        $query = $this
            ->backupToolRepository
            ->getQuery();

        return $this
            ->backupToolRepository
            ->deleteBackupTool($query, $id);
    }
}
