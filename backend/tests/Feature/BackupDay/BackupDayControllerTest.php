<?php

namespace Tests\Feature\BackupDay;

use App\Models\BackupDay;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BackupDayControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=BackupDayControllerTest
     *
     * @return void
     */
    public function test_create_backup_day_without_required_field_name_422_error(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/backup-days', []);

        // assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_create_backup_day_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();

        $this->actingAs($user);
        $dataPrepare =  [
            'name' => 'some name',
        ];

        // act
        $response = $this->post('admin/backup-days', $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'backupDay was created']);
        $response->assertJson([
            'data' => [
                'backupDay' => [
                    'name' => $dataPrepare['name'],
                    'description' => null,
                ],
            ],
        ]);
    }

    public function test_create_backup_days_with_all_field_success(): void
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
        $response = $this->post('admin/backup-days', $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'backupDay was created']);
        $response->assertJson([
            'data' => [
                'backupDay' => [
                    'name' => $dataPrepare['name'],
                    'description' => $dataPrepare['description'],
                ],
            ],
        ]);
    }

    public function test_show_backup_day_by_id_if_exist_database_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $dayCreated = BackupDay::factory()->create();

        // act
        $response = $this->get("admin/backup-days/{$dayCreated->id}");

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Find backupDay by id:{$dayCreated->id}"]);
        $response->assertJson([
            'data' => [
                'backupDay' => [
                    'name' => $dayCreated['name'],
                    'description' => $dayCreated['description'],
                ],
            ],
        ]);
    }

    public function test_show_backup_day_by_id_if_not_exist_database_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $findById = random_int(1, 100);

        // act
        $response = $this->get("admin/backup-days/{$findById}");

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson(['message' => "BackupDay by id:{$findById} not found"]);
        $response->assertJson([
            'data' => [
                'backupDay' => [],
            ],
        ]);
    }

    public function test_update_backup_day_if_not_exist()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $findById = random_int(1, 100);

        $dataPrepare =  [
            'name' => 'some name',
            'description' => 'some description',
        ];

        // act
        $response = $this->put("admin/backup-days/{$findById}", $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson(['message' => "BackupDay by id:{$findById} not found"]);
        $response->assertJson([
            'data' => [
                'backupDay' => [],
            ],
        ]);
    }

    public function test_update_backup_day_if_exist()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $dayCreated = BackupDay::factory()->create();

        $dataPrepare =  [
            'name' => 'some name',
            'description' => 'some description',
        ];

        // act
        $response = $this->put("admin/backup-days/{$dayCreated->id}", $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Update backupDay by id:{$dayCreated->id}"]);
        $response->assertJson([
            'data' => [
                'backupDay' => [
                    'id' => $dayCreated->id,
                    'name' => $dataPrepare['name'],
                    'description' => $dataPrepare['description'],
                ],
            ],
        ]);
    }

    public function test_delete_backup_object_by_id_if_exist_in_database(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $dayCreated = BackupDay::factory()->create();

        // act

        $response = $this->delete("admin/backup-days/{$dayCreated->id}");

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Delete backupDay by id:{$dayCreated->id}"]);
        $response->assertJson([
            'data' => [
                "isDelete" => true,
            ],
        ]);
    }

    public function test_delete_backup_object_by_id_if_not_exist_in_database(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $dayCreated = random_int(1, 100);

        // act

        $response = $this->delete("admin/backup-days/{$dayCreated}");

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => "Delete backupDay by id:{$dayCreated}"]);
        $response->assertJson([
            'data' => [
                "isDelete" => false,
            ],
        ]);
    }
}
