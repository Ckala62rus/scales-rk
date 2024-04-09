<?php

namespace App\Services;

use App\Contracts\Day\BackupDayRepositoryInterface;
use App\Contracts\Day\BackupDayServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupDayService implements BackupDayServiceInterface
{
    public function __construct(
        private BackupDayRepositoryInterface $backupDayRepository
    ){}

    /**
     * Get all backup day Entities with pagination
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllBackupDaysWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->backupDayRepository
            ->getQuery();

        return $this
            ->backupDayRepository
            ->getAllBackupDaysWithPagination($query, $limit);
    }

    /**
     * Get all backup day entities collection
     * @param array $filter
     * @return Collection
     */
    public function getAllBackupDaysCollection(array $filter): Collection
    {
        $query = $this
            ->backupDayRepository
            ->getQuery();

        return $this
            ->backupDayRepository
            ->getAllBackupDaysCollection($query);
    }

    /**
     * Get backup day entity by id
     * @param array $data
     * @return Model
     */
    public function createBackupDay(array $data): Model
    {
        $query = $this
            ->backupDayRepository
            ->getQuery();

        return $this
            ->backupDayRepository
            ->createBackupDay($query, $data);
    }

    /**
     * Get backup day by id or return null if not exist in database
     * @param int $id
     * @return Model|null
     */
    public function getBackupDayById(int $id): ?Model
    {
        $query = $this
            ->backupDayRepository
            ->getQuery();

        return $this
            ->backupDayRepository
            ->getBackupDayById($query, $id);
    }

    /**
     * Update backup day by id and return model or return null if not exist
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackupDay(int $id, array $data): ?Model
    {
        $query = $this
            ->backupDayRepository
            ->getQuery();

        return $this
            ->backupDayRepository
            ->updateBackupDay($query, $id, $data);
    }

    /**
     * Delete backup day by id
     * @param int $id
     * @return bool
     */
    public function deleteBackupDay(int $id): bool
    {
        $query = $this
            ->backupDayRepository
            ->getQuery();

        return $this
            ->backupDayRepository
            ->deleteBackupDay($query, $id);
    }
}
