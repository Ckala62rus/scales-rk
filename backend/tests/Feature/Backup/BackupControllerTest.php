<?php

namespace Tests\Feature\Backup;

use App\Models\Backup;
use App\Models\BackupObject;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;
use Throwable;

class BackupControllerTest extends TestCase
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
     * @param Organization $organization
     * @param BackupObject $backupObject
     * @return array
     */
    private function getData(Organization $organization, BackupObject $backupObject): array
    {
        return [
            'service' => 'service  test',
            'owner' => 'owner  test',
            'hostname' => 'hostname  test',
            'backup_object_id' => $backupObject->backup_object_id,
            'tool' => 'tool  test',
            'bd' => 'bd  test',
            'restricted_point' => 'restricted_point  test',
            'type' => 'type  test',
            'day' => 'day  test',
            'time_start' => 'time_start test',
            'storage_server' => 'storage_server test',
            'storage_long_time' => 'storage_long_time test',
            'organization_id' => $organization->id,
        ];
    }

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupControllerTest
     *
     * @return void
     * @throws Throwable
     */
    public function test_create_backup_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user           = User::factory()->create();
        $organization   = Organization::factory()->create();
        $backupObject   = BackupObject::factory()->create();

        $this->actingAs($user);
        $data = $this->getData($organization, $backupObject);

        $data['backup_object_id'] = $backupObject->id;

        // act
        $response = $this->post('admin/backups', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Backup was created']);
        $response->assertJson([
            'data' => [
                'backup' => [
                    'service' => $data['service'],
                    'user_id' => $user->id,
                    'organization_id' => $organization->id,
                ],
            ],
        ]);
    }

    public function test_create_backup_if_field_service_is_empty_fail(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user           = User::factory()->create();
        $organization   = Organization::factory()->create();
        $backupObject   = BackupObject::factory()->create();

        $this->actingAs($user);
        $data = $this->getData($organization, $backupObject);

        // remove required field for validation
        unset($data['service']);

        // act
        $response = $this->post('admin/backups', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'service' => 'The service field is required.',
        ]);
    }

    public function test_create_backup_if_field_backup_object_id_is_empty_fail(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user           = User::factory()->create();
        $organization   = Organization::factory()->create();
        $backupObject   = BackupObject::factory()->create();

        $this->actingAs($user);
        $data = $this->getData($organization, $backupObject);

        // remove required field for validation
        unset($data['backup_object_id']);

        // act
        $response = $this->post('admin/backups', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'backup_object_id' => 'The backup object id field is required.',
        ]);
    }

    public function test_create_backup_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'service' => 'service  test',
            'owner' => 'owner  test',
            'hostname' => 'hostname  test',
            'object' => 'object  test',
            'tool' => 'tool  test',
            'bd' => 'bd  test',
            'restricted_point' => 'restricted_point  test',
            'type' => 'type  test',
            'day' => 'day  test',
            'time_start' => 'time_start test',
            'storage_server' => 'storage_server test',
            'storage_long_time' => 'storage_long_time test',
        ];

        // act
        $response = $this->post('admin/backups', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'organization_id' => 'The organization id field is required.',
        ]);
    }

    public function test_read_backup_by_id_success(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $backupCreate = Backup::factory()->create();

        // act
        $response = $this->get('admin/backups/' . $backupCreate->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Get backup by id:$backupCreate->id"]);
        $response->assertJson([
            'data' => [
                'backup' => [
                    'service' => $backupCreate->service,
                    'user_id' => $backupCreate->user_id,
                    'organization_id' => $backupCreate->organization_id,
                ],
            ],
        ]);
    }

    public function test_read_backup_by_id_if_not_exist(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        $idFromSearch = random_int(1, 100);

        // act
        $response = $this->get('admin/backups/' . $idFromSearch);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson(['message' => "Get backup by id:$idFromSearch"]);
        $response->assertJson([
            'data' => [
                'backup' => [],
            ],
        ]);
    }

    public function test_update_backup_success()
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $backups = Backup::factory(2)->create();
        $newOrganization = Organization::factory()->create();

        $dataForUpdate = [
            'hostname' => 'updated hostname',
            'organization_id' => $newOrganization->id,
            'service' => $backups[1]->service,
            'backup_object_id' => $backups[1]->backup_object_id,
        ];

        // act
        $response = $this->put('admin/backups/' . $backups[1]->id, $dataForUpdate);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Backup was updated"]);
        $response->assertJson([
            'data' => [
                'backup' => [
                    'hostname' => $dataForUpdate['hostname'],
                    'organization_id' => $dataForUpdate['organization_id'],
                ],
            ],
        ]);
    }

    public function test_delete_backup_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $user->syncRoles(Role::create(['name'=>'super']));
        $this->actingAs($user);
        $backup = Backup::factory()->create();

        // act
        $response = $this->delete('admin/backups/' . $backup->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'delete' => true,
            ],
        ]);
    }

    public function test_delete_backup_fail(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $user->syncRoles(Role::create(['name'=>'super']));
        $this->actingAs($user);

        // act
        $response = $this->delete('admin/backups/' . random_int(1,100));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'delete' => false,
            ],
        ]);
    }
}
