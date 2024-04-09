<?php

namespace App\Services;

use App\Contracts\DeviceRepositoryInterface;
use App\Contracts\DeviceServiceInterface;
use App\Contracts\EquipmentServiceInterface;
use App\Contracts\OrganizationServiceInterface;
use App\Contracts\UserServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Exception\NotFoundException;

class DeviceService implements DeviceServiceInterface
{

    /**
     * @param DeviceRepositoryInterface $deviceRepository
     * @param OrganizationServiceInterface $organizationService
     * @param EquipmentServiceInterface $equipmentService
     * @param UserServiceInterface $userService
     */
    public function __construct(
        private UserServiceInterface $userService,
        private EquipmentServiceInterface $equipmentService,
        private OrganizationServiceInterface $organizationService,
        private DeviceRepositoryInterface $deviceRepository,
    ) {}

    /**
     * Get all devices with pagination and filters
     * @param int $limit
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllDevicesWithPagination(int $limit, array $filter): LengthAwarePaginator
    {
        $query = $this
            ->deviceRepository
            ->getQuery();

        $query = $this
            ->setFilterForSearch($query, $filter);

        $query = $this
            ->deviceRepository
            ->withDeviceRelation($query, [
                'user',
                'organization',
                'equipment'
            ]);

        return $this
            ->deviceRepository
            ->getAllDevicesWithPagination($query, $limit);
    }

    /**
     * Get all devices collection
     * @param array $filter
     * @return Collection
     */
    public function getAllDevicesCollection(array $filter): Collection
    {
        $query = $this
            ->deviceRepository
            ->getQuery();

        $query = $this
            ->setFilterForSearch($query, $filter);

        $query = $this
            ->deviceRepository
            ->withDeviceRelation($query, [
                'user',
                'organization',
                'equipment'
            ]);

        return $this
            ->deviceRepository
            ->getAllDevicesCollection($query);
    }

    /**
     * Create device
     * @param array $data
     * @return Model
     */
    public function createDevice(array $data): Model
    {
        $this->checkExistForeignKeyEntity($data);

        $query = $this
            ->deviceRepository
            ->getQuery();

        return $this
            ->deviceRepository
            ->createDevice($query, $data);
    }

    /**
     * Get device by id
     * @param int $id
     * @return Model|null
     */
    public function getDeviceById(int $id): ?Model
    {
        $query = $this
            ->deviceRepository
            ->getQuery();

        $query = $this
            ->deviceRepository
            ->withDeviceRelation($query, [
                'user',
                'organization',
                'equipment'
            ]);

        return $this
            ->deviceRepository
            ->getDeviceById($query, $id);
    }

    /**
     * Update device
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function updateDevice(int $id, array $data): ?Model
    {
        $query = $this
            ->deviceRepository
            ->getQuery();

        $this->checkExistForeignKeyEntity($data);

        return $this
            ->deviceRepository
            ->updateDevice($query, $id, $data);
    }

    /**
     * Delete device by  id
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteDevice(int $id): bool
    {
        $query = $this
            ->deviceRepository
            ->getQuery();

        $user = $this
            ->userService
            ->getUserById(Auth::user()->id);

        $device = $this
            ->deviceRepository
            ->getDeviceById($query, $id);

        if ($user->hasRole('user') && $user->organization_id == $device->organization_id) {
            return $this
                ->deviceRepository
                ->deleteDevice($query, $id);
        }

        if ($user->hasRole('user') && $user->organization_id != $device->organization_id) {
            throw new Exception(
                'Нельзя удалить эту запись, так как вы её не создавали!
                Удалить запись может администратор или тот пользователь,
                который относится к этой организации'
            );
        }

        if (count($user->roles) > 0 && $user->roles->first()->name === 'super'){
            return $this
                ->deviceRepository
                ->deleteDevice($query, $id);
        }

        throw new Exception(
            'У Вас отсутствуют роли, обратитесь к администратору.'
        );
    }

    /**
     * Check and return exception
     * @param array $data
     * @return void
     */
    private function checkExistForeignKeyEntity(array $data): void
    {

        if (isset($data['organization_id'])){
            $organization = $this
                ->organizationService
                ->getOrganizationsById($data['organization_id']);

            if (!$organization) {
                throw new NotFoundException('Organization not found in database!');
            }
        }

        if (isset($data['equipment_id'])){
            $equipment = $this
                ->equipmentService
                ->getEquipmentById($data['equipment_id']);

            if (!$equipment) {
                throw new NotFoundException('Equipment not found in database!');
            }
        }

        if (isset($data['user_id'])){
            $user = $this
                ->userService
                ->getUserById($data['user_id']);

            if (!$user) {
                throw new NotFoundException("User not found in database!");
            }
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

        if(isset($filter['equipment_id']) && $filter['equipment_id'] != 0) {
            $query = $query->where('equipment_id', $filter['equipment_id']);
        }

        if(isset($filter['hostname']) && $filter['hostname'] != 0) {
            $query = $query->where('hostname', 'LIKE', '%' . $filter['hostname'] . '%');
        }

        if(isset($filter['model']) && $filter['model'] != 0) {
            $query = $query->where('model', 'LIKE', '%' . $filter['model'] . '%');
        }

        if(isset($filter['operation_system']) && $filter['operation_system'] != 0) {
            $query = $query->where('operation_system', 'LIKE', '%' . $filter['operation_system'] . '%');
        }

        if(isset($filter['description_service']) && $filter['description_service'] != 0) {
            $query = $query->where('description_service', 'LIKE', '%' . $filter['description_service'] . '%');
        }

        if(isset($filter['cpu']) && $filter['cpu'] != 0) {
            $query = $query->where('cpu', 'LIKE', '%' . $filter['cpu'] . '%');
        }

        if(isset($filter['comment']) && $filter['comment'] != 0) {
            $query = $query->where('comment', 'LIKE', '%' . $filter['comment'] . '%');
        }

        return $query;
    }
}
