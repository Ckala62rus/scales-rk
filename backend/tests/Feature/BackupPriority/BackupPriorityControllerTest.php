<?php

namespace Tests\Feature\BackupPriority;

use App\Models\BackupPriority;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class BackupPriorityControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=BackupPriorityControllerTest
     *
     * @return void
     */
    public function test_create_backup_priority_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = ['name' => 'low priority'];

        // act
        $response = $this->post('admin/backup-priorities', $data);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Backup priority was created']);
        $response->assertJson([
            'data' => [
                'backupPriority' => [
                    'name' => $data['name'],
                ],
            ],
        ]);
    }

    public function test_create_backup_priority_fail(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [];

        // act
        $response = $this->post('admin/backup-priorities', $data);

        // assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_show_backup_priority_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = ['name'=>'low priority'];
        $priority = BackupPriority::factory()->create($data);

        // act
        $response = $this->get('admin/backup-priorities/' . $priority->id);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Backup priority by id:' . $priority->id]);
        $response->assertJson([
            'data' => [
                'backupPriority' => [
                    'name' => $data['name'],
                ],
            ],
        ]);
    }

    public function test_show_backup_priority_if_not_exist_in_database(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get('admin/backup-priorities/' . random_int(1,100));

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson([
            'data' => [
                'backupPriority' => [],
            ],
        ]);
    }

    public function test_update_backup_priority_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $dataForCreate = ['name' => 'low priority'];
        $dataForUpdate = ['name' => 'high priority'];
        $createdPriority = BackupPriority::factory()->create($dataForCreate);

        // act
        $response = $this->put('admin/backup-priorities/' . $createdPriority->id, $dataForUpdate);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'backupPriority' => [
                    'name' => $dataForUpdate['name'],
                ],
            ]
        ]);
    }

    public function test_update_backup_priority_required_field_name_fail(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $dataForCreate = ['name' => 'low priority'];
        $dataForUpdate = [];
        $createdPriority = BackupPriority::factory()->create($dataForCreate);

        // act
        $response = $this->put('admin/backup-priorities/' . $createdPriority->id, $dataForUpdate);

        // assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_delete_backup_priority_by_id_if_exists_in_database(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $createdPriority = BackupPriority::factory()->create();

        // act
        $response = $this->delete('admin/backup-priorities/' . $createdPriority->id);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'delete' => true,
            ]
        ]);
    }

    public function test_delete_backup_priority_by_id_if_not_exists_in_database(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->delete('admin/backup-priorities/' . random_int(1,100));

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'delete' => false,
            ]
        ]);
    }
}
