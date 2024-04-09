<?php

namespace Tests\Feature\BackupObject;

use App\Models\BackupObject;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BackupObjectControllerTest extends TestCase
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
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupObjectControllerTest
     *
     * @return void
     * @throws \Throwable
     */
    public function test_create_backup_objects_without_required_field_name_422_error(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/backup-objects', []);

        // assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_create_backup_objects_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();

        $this->actingAs($user);
        $dataPrepare =  [
            'name' => 'some name',
        ];

        // act
        $response = $this->post('admin/backup-objects', $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'BackupObject was create']);
        $response->assertJson([
            'data' => [
                'backupObject' => [
                    'name' => $dataPrepare['name'],
                    'description' => null,
                ],
            ],
        ]);
    }

    public function test_create_backup_objects_with_all_field_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();

        $this->actingAs($user);
        $dataPrepare =  [
            'name' => 'some name',
            'description' => 'some description',
        ];

        // act
        $response = $this->post('admin/backup-objects', $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'BackupObject was create']);
        $response->assertJson([
            'data' => [
                'backupObject' => [
                    'name' => $dataPrepare['name'],
                    'description' => 'some description',
                ],
            ],
        ]);
    }

    public function test_show_backup_object_by_id_if_exist_database_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $backupObject = BackupObject::factory()->create();

        // act
        $response = $this->get('admin/backup-objects/' . $backupObject->id);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Find backupObject by id:' . $backupObject->id]);
        $response->assertJson([
            'data' => [
                'backupObject' => [
                    'id' => $backupObject->id,
                    'name' => $backupObject->name,
                    'description' => $backupObject->description,
                ],
            ],
        ]);
    }

    public function test_show_backup_object_by_id_if_not_exist_database()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $randomInteger = random_int(1,100);

        // act
        $response = $this->get('admin/backup-objects/' . $randomInteger);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson(['message' => 'BackupObject not found with id:' . $randomInteger]);
        $response->assertJson([
            'data' => [
                'backupObject' => [],
            ],
        ]);
    }

    public function test_update_backup_object_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $backupObject = BackupObject::factory()->create();

        $dataForUpdate = [
            'name' => 'updated name',
        ];

        // act
        $response = $this->put('admin/backup-objects/' . $backupObject->id, [
            'name' => $dataForUpdate['name'],
        ]);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Updated backupObject by id:' . $backupObject->id]);
        $response->assertJson([
            'data' => [
                'backupObject' => [
                    'name' => $dataForUpdate['name']
                ],
            ],
        ]);
    }

    public function test_delete_backup_object_by_id_if_exist_in_database()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $backupObject = BackupObject::factory()->create();

        // act
        $response = $this->delete('admin/backup-objects/' . $backupObject->id);

        // arrange
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Delete backupObject by id:' . $backupObject->id]);
        $response->assertJson([
            'data' => [
                'isDelete' => true,
            ],
        ]);
    }

    public function test_delete_backup_object_by_id_if_not_exist_in_database()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $randomInteger = random_int(1, 100);

        // act
        $response = $this->delete('admin/backup-objects/' . $randomInteger);

        // arrange
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Delete backupObject by id:' . $randomInteger]);
        $response->assertJson([
            'data' => [
                'isDelete' => false,
            ],
        ]);
    }
}
