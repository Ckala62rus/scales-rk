<?php

namespace Tests\Feature\BackupTool;

use App\Models\BackupTool;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BackupToolControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=BackupToolControllerTest
     *
     * @return void
     */
    public function test_create_backup_tool_without_required_field_name_422_error(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/backup-tools', []);

        // assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_create_backup_tools_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $dataPrepare = ['name' => 'some name'];

        // act
        $response = $this->post('admin/backup-tools', $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'backupTool was create']);
        $response->assertJson([
            'data' => [
                'backupTool' => [
                    'name' => $dataPrepare['name'],
                    'description' => null,
                ],
            ],
        ]);
    }

    public function test_create_backup_tools_with_all_field_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $dataPrepare = [
            'name' => 'some name',
            'description' => 'new description'
        ];

        // act
        $response = $this->post('admin/backup-tools', $dataPrepare);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'backupTool was create']);
        $response->assertJson([
            'data' => [
                'backupTool' => [
                    'name' => $dataPrepare['name'],
                    'description' => $dataPrepare['description'],
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
        $toolCreated = BackupTool::factory()->create();

        // act
        $response = $this->get('admin/backup-tools/' . $toolCreated->id);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Find backup tool by id:' . $toolCreated->id]);
        $response->assertJson([
            'data' => [
                'backupTool' => [
                    'name' => $toolCreated->name,
                    'description' => $toolCreated->description,
                ],
            ],
        ]);
    }

    public function test_show_backup_tool_by_id_if_not_exist_database()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $randomInteger = random_int(1, 100);

        // act
        $response = $this->get('admin/backup-tools/' . $randomInteger);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson(['message' => 'Backup tool not found by id:' . $randomInteger]);
        $response->assertJson([
            'data' => [
                'backupTool' => [],
            ],
        ]);
    }

    public function test_update_backup_tool_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $toolCreated = BackupTool::factory()->create();
        $dataForUpdate = [
            'name' => 'name was updated'
        ];

        // act
        $response = $this->put('admin/backup-tools/' . $toolCreated->id, $dataForUpdate);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Updated backup tool by id:' . $toolCreated->id]);
        $response->assertJson([
            'data' => [
                'backupTool' => [
                    'name' => $dataForUpdate['name'],
                ],
            ],
        ]);
    }

    public function test_delete_backup_tool_by_id_if_exist_in_database()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $toolCreated = BackupTool::factory()->create();

        // act
        $response = $this->delete('admin/backup-tools/' . $toolCreated->id);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Delete backup tool by id:' . $toolCreated->id]);
        $response->assertJson([
            'data' => [
                'isDelete' => true,
            ],
        ]);
    }

    public function test_delete_backup_tool_by_id_if_not_exist_in_database()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $randomInteger = random_int(1,100);

        // act
        $response = $this->delete('admin/backup-tools/' . $randomInteger);

        // assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Delete backup tool by id:' . $randomInteger]);
        $response->assertJson([
            'data' => [
                'isDelete' => false,
            ],
        ]);
    }
}
