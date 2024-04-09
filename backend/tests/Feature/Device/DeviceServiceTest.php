<?php

namespace Tests\Feature\Device;

use App\Models\Device;
use App\Models\Equipment;
use App\Models\Organization;
use App\Models\User;
use App\Services\DeviceService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeviceServiceTest extends TestCase
{
    use DatabaseTransactions;

    private function getData(User $user, Organization $organization, Equipment $equipment)
    {
        return [
            'hostname' => 'test',
            'model' => 'test',
            'date_buy' => '2023-05-26',
            'description_service' => 'test',
            'date_update' => '2023-05-26',
            'operation_system' => 'test',
            'cpu' => 'test',
            'count_core' => 8,
            'count_core_with_ht' => 8,
            'memory' => 1024,
            'hdd' => 1024.12,
            'ssd' => 1024,
            'address' => 'test',
            'comment' => 'test',
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'equipment_id' => $equipment->id,
        ];
    }

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=DeviceServiceTest
     *
     * @return void
     */
    public function test_create_device_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $organization = Organization::factory()->create();
        $equipment = Equipment::factory()->create();

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        $data = $this->getData($user, $organization, $equipment);

        // act
        $dev = $service->createDevice($data);

        // assert
        $this->assertIsFloat($dev->hdd);
        $this->assertEquals($dev->user_id, $user->id);
        $this->assertEquals($dev->organization_id, $organization->id);
        $this->assertEquals($dev->equipment_id, $equipment->id);
        $this->assertDatabaseCount('devices',1);
    }

    public function test_create_device_with_custom_fields_success(): void
    {
        // arrange
        $user           = User::factory()->create();
        $organization   = Organization::factory()->create(['name' => 'some organization']);
        $equipment      = Equipment::factory()->create(['name' => 'server']);
        $device         = Device::factory()->create(
            [
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'equipment_id' => $equipment->id,
            ]
        );

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        // act
        $dev = $service->getDeviceById($device->id);

        // assert
        $this->assertEquals($dev->user->name, $user->name);
        $this->assertEquals($dev->user->id, $user->id);
        $this->assertEquals($dev->organization->id, $organization->id);
        $this->assertEquals($dev->organization->name, $organization->name);
        $this->assertEquals($dev->equipment->id, $equipment->id);
        $this->assertEquals($dev->equipment->name, $equipment->name);
    }

    public function test_get_device_by_id_success()
    {
        // arrange
        $device = Device::factory()->create();

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        // act
        $result = $service->getDeviceById($device->id);

        // assert
        $this->assertEquals($result->id, $device->id);
        $this->assertDatabaseCount(Device::class, 1);
    }

    public function test_get_device_by_id_if_not_exist()
    {
        // arrange
        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        // act
        $result = $service->getDeviceById(random_int(1, 10));

        // assert
        $this->assertNull($result);
    }

    public function test_get_collection_devices()
    {
        // arrange
        $devices = Device::factory(10)->create();

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        // act
        $result = $service->getAllDevicesCollection([]);

        // assert
        $this->assertCount($devices->count(), $result);
    }

    public function test_update_device_success()
    {
        // arrange
        $device = Device::factory()->create([
            'hostname' => 'test',
            'model' => 'test',
            'date_buy' => Carbon::now()->subDay(1),
            'date_update' => Carbon::now()->addDays(10),
            'cpu' => 10,
        ]);

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        $dateForUpdate = [
            'hostname' => 'test_host',
            'model' => 'test_model',
            'date_buy' => Carbon::now()->subDay(2),
            'date_update' => Carbon::now()->addDays(30),
            'cpu' => 5,
        ];

        // act
        $deviceUpdated = $service->updateDevice($device->id, $dateForUpdate);

        // assert
        $this->assertNotEquals($deviceUpdated->hostname, $device->hostname);
        $this->assertNotEquals($deviceUpdated->model, $device->model);
        $this->assertNotEquals($deviceUpdated->date_buy, $device->date_buy);
        $this->assertNotEquals($deviceUpdated->date_update, $device->date_update);
        $this->assertNotEquals($deviceUpdated->cpu, $device->cpu);
    }

    public function test_delete_device_if_exist_success()
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->syncRoles(Role::create(['name'=>'super']));

        $device = Device::factory()->create();

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        // act
        $isDelete = $service->deleteDevice($device->id);

        // assert
        $this->assertTrue($isDelete);
        $this->assertDatabaseCount(Device::class, 0);
    }

    public function test_delete_device_if_not_exist_fail()
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->syncRoles(Role::create(['name'=>'super']));

        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);

        // act
        $isDelete = $service->deleteDevice(random_int(1, 10));

        // assert
        $this->assertFalse($isDelete);
        $this->assertDatabaseCount(Device::class, 0);
    }

    public function test_delete_one_device()
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->syncRoles(Role::create(['name'=>'super']));;

        $devices = Device::factory(2)->create();

        // act
        /** @var DeviceService $service */
        $service = $this->app->make(DeviceService::class);
        $isDelete = $service->deleteDevice($devices[0]->id);

        // assert
        $this->assertTrue($isDelete);
        $this->assertDatabaseCount(Device::class, 1);
    }
}
