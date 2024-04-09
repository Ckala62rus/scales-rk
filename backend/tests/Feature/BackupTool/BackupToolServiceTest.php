<?php

namespace Tests\Feature\BackupTool;

use App\Contracts\BackupTool\BackupToolServiceInterface;
use App\Models\BackupTool;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackupToolServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupToolServiceTest
     *
     * @return void
     */
    public function test_create_backup_tool_success(): void
    {
        // arrange
        $data = ['name' => 'some name'];

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $backupTool = $service->createBackupTool($data);

        // assert
        $this->assertEquals($backupTool->name, $data['name']);
        $this->assertEquals($backupTool->description, null);
    }

    public function test_create_backup_tool_with_description_success(): void
    {
        // arrange
        $data = ['name' => 'some name', 'description' => 'some description'];

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $backupTool = $service->createBackupTool($data);

        // assert
        $this->assertEquals($backupTool->name, $data['name']);
        $this->assertEquals($backupTool->description, $data['description']);
    }

    public function test_create_backup_object_if_field_name_is_empty_fail(): void
    {
        // arrange
        $data = [];

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createBackupTool($data);
        }, QueryException::class);
    }

    public function test_read_backup_tool_if_exist_success(): void
    {
        // arrange
        $toolCreated = BackupTool::factory()->create();

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $tool = $service->getBackupToolById($toolCreated->id);

        // assert
        $this->assertEquals($tool->id, $toolCreated->id);
        $this->assertEquals($tool->name, $toolCreated->name);
        $this->assertEquals($tool->description, $toolCreated->description);
    }

    public function test_read_backup_tool_if_not_exist_success(): void
    {
        // arrange
        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $tool = $service->getBackupToolById(random_int(1, 100));

        // assert
        $this->assertNull($tool);
    }

    public function test_update_backup_object_success()
    {
        // arrange
        $toolCreated = BackupTool::factory()->create();

        $dateForUpdate = [
            'name' => 'updated name',
        ];

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $tool = $service->updateBackupTool($toolCreated->id, $dateForUpdate);

        // assert
        $this->assertEquals($tool->id, $toolCreated->id);
        $this->assertNotEquals($tool->name, $toolCreated->name);
        $this->assertEquals($tool->description, $toolCreated->description);
    }

    public function test_update_backup_object_if_not_found_return_null()
    {
        // arrange
        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $tool = $service->updateBackupTool(random_int(1, 100), []);

        // assert
        $this->assertNull($tool);
    }

    public function test_delete_backup_object_if_exist_return_true()
    {
        // arrange
        $tool = BackupTool::factory()->create();

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $result = $service->deleteBackupTool($tool->id);

        // assert
        $this->assertTrue($result);
    }

    public function test_delete_backup_object_if_not_exist_return_false()
    {
        // arrange
        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $result = $service->deleteBackupTool(random_int(1, 100));

        // assert
        $this->assertFalse($result);
    }

    public function test_double_delete_backup_object_if_exist_return_false()
    {
        // arrange
        $tool = BackupTool::factory()->create();

        /** @var BackupToolServiceInterface $service */
        $service = $this->app->make(BackupToolServiceInterface::class);

        // act
        $service->deleteBackupTool($tool->id);
        $result = $service->deleteBackupTool($tool->id);

        // assert
        $this->assertFalse($result);
    }
}
