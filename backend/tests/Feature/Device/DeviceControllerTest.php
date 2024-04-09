<?php

namespace Tests\Feature\Device;

use App\Models\Device;
use App\Models\Equipment;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class DeviceControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'accept' => 'application/json'
        ]);
    }

    /**
     * Return prepare array
     * @param User $user
     * @param Organization $organization
     * @param Equipment $equipment
     * @return array
     */
    private function getData(User $user, Organization $organization, Equipment $equipment): array
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
            'memory' => '1024.000',
            'hdd' => '1024.000',
            'ssd' => '1024.000',
            'address' => 'test',
            'comment' => 'test',
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'equipment_id' => $equipment->id,
        ];
    }

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=DeviceControllerTest
     *
     * @return void
     * @throws \Throwable
     */
    public function test_store_device_controller_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user           = User::factory()->create();
        $organization   = Organization::factory()->create();
        $equipment      = Equipment::factory()->create();

        $this->actingAs($user);
        $data = $this->getData($user, $organization, $equipment);

        // act
        $response = $this->post('admin/devices', $data);

        //assert
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Device was created']);
        $response->assertJson([
            'data' => [
                'device' => [
                    'hostname' => $data['hostname'],
                    'model' => $data['model'],
                    'date_buy' => $data['date_buy'],
                    'description_service' => $data['description_service'],
                    'date_update' => $data['date_update'],
                    'operation_system' => $data['operation_system'],
                    'cpu' => $data['cpu'],
                    'count_core' => $data['count_core'],
                    'count_core_with_ht' => $data['count_core_with_ht'],
                    'memory' => $data['memory'],
                    'hdd' => $data['hdd'],
                    'ssd' => $data['ssd'],
                    'address' => $data['address'],
                    'comment' => $data['comment'],

                    'user_id' => $data['user_id'],
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ],

                    'organization_id' => $data['organization_id'],
                    'organization' => [
                        'id' => $organization->id,
                        'name' => $organization->name,
                    ],

                    'equipment_id' => $data['equipment_id'],
                    'equipment' => [
                        'id' => $equipment->id,
                        'name' => $equipment->name,
                    ],
                ]
            ]
        ]);
    }

    public function test_store_device_controller_if_organization_not_exist_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user               = User::factory()->create();
        $equipment          = Equipment::factory()->create();
        $organization_id    = random_int(1,10);

        $this->actingAs($user);

        $data = [
            'hostname' => 'test',
            'model' => 'test',
            'date_buy' => '2023-05-26',
            'description_service' => 'test',
            'date_update' => '2023-05-26',
            'operation_system' => 'test',
            'cpu' => 'test',
            'count_core' => 8,
            'count_core_with_ht' => 8,
            'memory' => '1024.000',
            'hdd' => '1024.000',
            'ssd' => '1024.000',
            'address' => 'test',
            'comment' => 'test',
            'user_id' => $user->id,
            'organization_id' => $organization_id,
            'equipment_id' => $equipment->id,
        ];

        // act
        $response = $this->post('admin/devices', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => false,
            'message' => 'Organization not found in database!',
            'data' => [
                'device' => null,
            ]
        ]);
    }

    public function test_store_device_controller_if_equipment_not_exist_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user            = User::factory()->create();
        $organization    = Organization::factory()->create();
        $equipment_id    = random_int(1,10);

        $this->actingAs($user);

        $data = [
            'hostname' => 'test',
            'model' => 'test',
            'date_buy' => '2023-05-26',
            'description_service' => 'test',
            'date_update' => '2023-05-26',
            'operation_system' => 'test',
            'cpu' => 'test',
            'count_core' => 8,
            'count_core_with_ht' => 8,
            'memory' => '1024.000',
            'hdd' => '1024.000',
            'ssd' => '1024.000',
            'address' => 'test',
            'comment' => 'test',
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'equipment_id' => $equipment_id,
        ];

        // act
        $response = $this->post('admin/devices', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => false,
            'message' => 'Equipment not found in database!',
            'data' => [
                'device' => null,
            ]
        ]);
    }

    public function test_store_device_controller_if_user_not_exist_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user            = User::factory()->create();
        $organization    = Organization::factory()->create();
        $equipment       = Equipment::factory()->create();

        $this->actingAs($user);

        $data = [
            'hostname' => 'test',
            'model' => 'test',
            'date_buy' => '2023-05-26',
            'description_service' => 'test',
            'date_update' => '2023-05-26',
            'operation_system' => 'test',
            'cpu' => 'test',
            'count_core' => 8,
            'count_core_with_ht' => 8,
            'memory' => '1024.000',
            'hdd' => '1024.000',
            'ssd' => '1024.000',
            'address' => 'test',
            'comment' => 'test',
            'user_id' => $user->id + 1, // (for test) this user not exist in database
            'organization_id' => $organization->id,
            'equipment_id' => $equipment->id,
        ];

        // act
        $response = $this->post('admin/devices', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => false,
            'message' => 'User not found in database!',
            'data' => [
                'device' => null,
            ]
        ]);
    }

    public function test_get_device_by_id_controller_if_exist_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user            = User::factory()->create();
        $organization    = Organization::factory()->create();
        $equipment       = Equipment::factory()->create();

        $this->actingAs($user);

        $data = $this->getData($user, $organization, $equipment);
        $response = $this->post('admin/devices', $data);

        $device_id = $response->decodeResponseJson()['data']['device']['id'];

        // act
        $response = $this->get('admin/devices/' . $device_id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => true,
            'message' => 'Device with id:' . $device_id,
            'data' => [
                'device' => [
                    'id' => $device_id,
                ],
            ]
        ]);
    }

    public function test_get_device_by_id_controller_if__not_exist_fail(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $device_id = random_int(1,100);

        // act
        $response = $this->get('admin/devices/' . $device_id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => false,
            'message' => "Device with id:$device_id not found!",
            'data' => [
                'device' => null,
            ]
        ]);
    }

    public function test_update_device_by_id_controller_success(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $organizations = Organization::factory(2)->create();
        $equipments = Equipment::factory(2)->create();

        $this->actingAs($user);

        $data = $this->getData($user, $organizations[0], $equipments[0]);

        $device_id = $this
            ->post('admin/devices', $data)
            ->decodeResponseJson()['data']['device']['id'];

        $device = $this->get('admin/devices/' . $device_id)->decodeResponseJson();

        // act
        $updateDeviceResponse = $this
            ->put('admin/devices/' . $device_id, [
                'hostname' => 'test_updated',
                'date_buy' => Carbon::parse($device['data']['device']['date_buy'])
                    ->subDay(1)
                    ->format('Y-m-d'),
                'address' => 'address_updated',
                'comment' => 'comment_updated',
                'organization_id' => $organizations[1]->id,
                'equipment_id' => $equipments[1]->id,
            ]);

        $result = $updateDeviceResponse->decodeResponseJson();

        // assert
        $updateDeviceResponse->assertStatus(ResponseAlias::HTTP_OK);
        $updateDeviceResponse->assertJson([
            'data' => [
                'device' => [
                    'organization_id' => $organizations[1]->id,
                    'equipment_id' => $equipments[1]->id
                ]
            ]
        ]);

        $this->assertNotEquals($result['data']['device']['organization']['name'], $organizations[0]->name);
        $this->assertNotEquals($result['data']['device']['equipment']['name'], $equipments[0]->name);
    }

    public function test_delete_device_controller_success()
    {
        // arrange
        $this->withExceptionHandling();
        $device = Device::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);
        $user->syncRoles(Role::create(['name'=>'super']));

        // act
        $response = $this->delete('admin/devices/' . $device->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => true,
            'message' => 'Device was deleted',
            'data' => [
                'delete' => true
            ]
        ]);
    }

    public function test_delete_device_controller_fail()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->syncRoles(Role::create(['name'=>'super']));

        // act
        $response = $this->delete('admin/devices/' . random_int(1,100));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'status' => true,
            'message' => 'Device was deleted',
            'data' => [
                'delete' => false
            ]
        ]);
    }
}
