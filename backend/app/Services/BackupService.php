<?php

namespace App\Services;

use App\Contracts\Backup\BackupRepositoryInterface;
use App\Contracts\Backup\BackupServiceInterface;
use App\Contracts\OrganizationServiceInterface;
use App\Contracts\UserServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BackupService implements BackupServiceInterface
{
    /**
     * @param BackupRepositoryInterface $backupRepository
     * @param UserServiceInterface $userService
     * @param OrganizationServiceInterface $organizationService
     */
    public function __construct(
        private BackupRepositoryInterface $backupRepository,
        private UserServiceInterface $userService,
        private OrganizationServiceInterface $organizationService,
    ){}

    /**
     * Get all backup with pagination and relation
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllBackupsWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->backupRepository
            ->getQuery();

        $query = $this
            ->setFilterForSearch($query, $filter);

        $query = $this
            ->backupRepository
            ->withBackupRelation($query, [
                'user',
                'organization',
            ]);

        return $this
            ->backupRepository
            ->getAllBackupsWithPagination($query, $limit);
    }

    /**
     * Get all backup collection without pagination
     * @param array $filter
     * @return Collection
     */
    public function getAllBackupsCollection(array $filter): Collection
    {
        $query = $this
            ->backupRepository
            ->getQuery();

        $query = $this
            ->setFilterForSearch($query, $filter);

        $query = $this
            ->backupRepository
            ->withBackupRelation($query, [
                'user',
                'organization',
            ]);

        return $this
            ->backupRepository
            ->getAllBackupsCollection($query);
    }

    /**
     * Create and return created model backup
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function createBackup(array $data): Model
    {
        $query = $this
            ->backupRepository
            ->getQuery();

        $data['user_id'] = Auth::user()->id;

        if (isset($data['backup_priority_id']) && $data['backup_priority_id'] === 0) {
            $data['backup_priority_id'] = null;
        }

        $this->checkExistForeignKeyEntity($data);

        return $this
            ->backupRepository
            ->createBackup($query, $data);
    }

    /**
     * Get backup by id or return null if not exist
     * @param int $id
     * @return Model|null
     */
    public function getBackupById(int $id): ?Model
    {
        $query = $this
            ->backupRepository
            ->getQuery();

        return $this
            ->backupRepository
            ->getBackupById($query, $id);
    }

    /**
     * Update backup model by id and return updated model
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateBackup(int $id, array $data): ?Model
    {
        $query = $this
            ->backupRepository
            ->getQuery();

        if (isset($data['backup_priority_id']) && $data['backup_priority_id'] === 0) {
            $data['backup_priority_id'] = null;
        }

        return $this
            ->backupRepository
            ->updateBackup($query, $id, $data);
    }

    /**
     * Delete backup by id and return boolean
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteBackup(int $id): bool
    {
        $query = $this
            ->backupRepository
            ->getQuery();

        $user = $this
            ->userService
            ->getUserById(Auth::user()->id);

        $backup = $this
            ->getBackupById($id);

        if ($user->hasRole('user') && $user->organization_id == $backup->organization_id) {
            return $this
                ->backupRepository
                ->deleteBackup($query, $id);
        }

        if ($user->hasRole('user') && $user->organization_id != $backup->organization_id) {
            throw new \InvalidArgumentException(
                'Нельзя удалить эту запись, так как вы её не создавали!
                Удалить запись может администратор или тот пользователь,
                который относится к этой организации'
            );
        }

        if (count($user->roles) > 0 && $user->roles->first()->name === 'super'){
            return $this
                ->backupRepository
                ->deleteBackup($query, $id);
        }

        throw new \InvalidArgumentException(
            'У Вас отсутствуют роли, обратитесь к администратору.'
        );
    }

    /**
     * Check and return exception
     * @param array $data
     * @return void
     * @throws Exception
     */
    private function checkExistForeignKeyEntity(array $data): void
    {
        if (isset($data['organization_id'])){
            $organization = $this
                ->organizationService
                ->getOrganizationsById($data['organization_id']);

            if (!$organization) {
                throw new NotFoundHttpException('Organization not found in database!');
            }
        } else {
            throw new NotFoundHttpException('organization_id not found');
        }

        if (isset($data['user_id'])){
            $user = $this
                ->userService
                ->getUserById($data['user_id']);

            if (!$user) {
                throw new NotFoundHttpException("User not found in database!");
            }
        } else {
            throw new NotFoundHttpException('user_id not found');
        }
    }

    /**
     * Set filter by search for Eloquent builder
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
    private function setFilterForSearch(Builder $query, array $filter): Builder
    {
        if(isset($filter['organization_id']) && $filter['organization_id'] != 0) {
            $query = $query->where('organization_id', $filter['organization_id']);
        }

        if(isset($filter['service']) && $filter['service'] != 0) {
            $query = $query->where('service', 'LIKE', '%' . $filter['service'] . '%');
        }

        if(isset($filter['hostname']) && $filter['hostname'] != 0) {
            $query = $query->where('hostname', 'LIKE', '%' . $filter['hostname'] . '%');
        }

        if(isset($filter['owner']) && $filter['owner'] != 0) {
            $query = $query->where('owner', 'LIKE', '%' . $filter['owner'] . '%');
        }

        if(isset($filter['backup_object_id']) && $filter['backup_object_id']) {
            $query = $query->where('backup_object_id', $filter['backup_object_id']);
        }

        if(isset($filter['backup_tool_id']) && $filter['backup_tool_id']) {
            $query = $query->where('backup_tool_id', $filter['backup_tool_id']);
        }

        if(isset($filter['comment']) && $filter['comment'] != 0) {
            $query = $query->where('comment', 'LIKE', '%' . $filter['comment'] . '%');
        }

        if(isset($filter['storage_server']) && $filter['storage_server'] != 0) {
            $query = $query->where('storage_server', 'LIKE', '%' . $filter['storage_server'] . '%');
        }

        if(isset($filter['backup_priority_id']) && $filter['backup_priority_id']) {
            $query = $query->where('backup_priority_id', $filter['backup_priority_id']);
        }

        return $query;
    }
}
