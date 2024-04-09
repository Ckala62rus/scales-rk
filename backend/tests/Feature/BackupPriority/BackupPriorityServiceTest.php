<?php

namespace Tests\Feature\BackupPriority;

use App\Models\BackupPriority;
use App\Services\BackupPriorityService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackupPriorityServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupPriorityServiceTest
     *
     * @return void
     */
    public function test_create_backup_priority_success(): void
    {
        // arrange
        $data = ['name' => 'low priority'];

        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        $backupPriority = $service->createBackupPriority($data);

        // assert
        $this->assertEquals($data['name'], $backupPriority->name);
    }

    public function test_create_backup_priority_fail(): void
    {
        // arrange
        $data = [];

        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createBackupPriority($data);
        }, QueryException::class);
    }

    public function test_create_backup_priority_unique_fail(): void
    {
        // arrange
        $data = ['name' => 'low priority'];

        $backupPriority = BackupPriority::factory()->create($data);

        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createBackupPriority($data);
        }, QueryException::class);
    }

    public function test_get_backup_priority_by_id_success(): void
    {
        // arrange
        $backupPriority = BackupPriority::factory()->create();

        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        $priority = $service->getBackupPriorityById($backupPriority->id);

        // assert
        $this->assertDatabaseCount(BackupPriority::class, 1);
        $this->assertEquals($backupPriority->name, $priority->name);
    }

    public function test_get_backup_priority_by_id_not_found_fail(): void
    {
        // arrange
        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        $priority = $service->getBackupPriorityById(random_int(1, 100));

        // assert
        $this->assertNull($priority);
    }

    public function test_update_backup_priority_success(): void
    {
        // arrange
        $data = ['name' => 'low priority'];

        $backupPriority = BackupPriority::factory()->create();
        $oldName = $backupPriority->name;

        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        $service->updateBackupPriority($backupPriority->id, $data);

        $obj = $service->getBackupPriorityById($backupPriority->id);

        // assert
        $this->assertNotEquals($oldName ,$obj->name);
        $this->assertEquals($backupPriority->id, $obj->id);
    }

    public function test_delete_backup_priority_success(): void
    {
        // arrange
        $backupPriority = BackupPriority::factory()->create();

        /** @var BackupPriorityService $service */
        $service = $this->app->make(BackupPriorityService::class);

        // act
        $isDelete = $service->deleteBackupPriority($backupPriority->id);

        // assert
        $this->assertTrue($isDelete);
    }
}
