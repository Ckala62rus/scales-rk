<?php

namespace Tests\Feature\BackupObject;

use App\Models\BackupObject;
use App\Services\BackupObjectService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackupObjectServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupObjectServiceTest
     *
     * @return void
     */
    public function test_create_backup_object_success(): void
    {
        // arrange
        $data = ['name' => 'new backup object'];

        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $backupObject = $service
            ->createBackupObject($data);

        // assert
        $this->assertEquals($backupObject->name, $data['name']);
        $this->assertEquals($backupObject->description, null);
    }

    public function test_create_backup_object_with_description_success(): void
    {
        // arrange
        $data = ['name' => 'new backup object', 'description' => 'some description'];

        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $backupObject = $service
            ->createBackupObject($data);

        // assert
        $this->assertEquals($backupObject->name, $data['name']);
        $this->assertEquals($backupObject->description, $data['description']);
    }

    public function test_create_backup_object_if_field_name_is_empty_fail(): void
    {
        // arrange
        $data = ['description' => 'some description'];

        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createBackupObject($data);
        }, QueryException::class);
    }

    public function test_read_backup_object_if_exist_success(): void
    {
        // arrange
        $backupObjectCreated = BackupObject::factory()->create();

        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $backup = $service
            ->getBackupObjectById($backupObjectCreated->id);

        // assert
        $this->assertEquals($backup->id, $backupObjectCreated->id);
        $this->assertEquals($backup->name, $backupObjectCreated->name);
        $this->assertEquals($backup->description, $backupObjectCreated->description);
    }

    public function test_read_backup_object_if_not_exist(): void
    {
        // arrange
        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $backup = $service
            ->getBackupObjectById(random_int(1, 100));

        // assert
        $this->assertNull($backup);
    }

    public function test_update_backup_object_success()
    {
        // arrange
        $backupCreated = BackupObject::factory()->create();

        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $backupUpdated = $service
            ->updateBackupObject($backupCreated->id, ['name' => 'updated was updated']);

        // assert
        $this->assertEquals($backupUpdated->id, $backupCreated->id);
        $this->assertNotEquals($backupUpdated->name, $backupCreated->name);
        $this->assertEquals($backupUpdated->description, $backupCreated->description);
    }

    public function test_update_backup_object_if_not_found_with_exception()
    {
        // arrange
        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service) {
            $service
                ->updateBackupObject(random_int(1, 100), ['name' => 'updated was updated']);
        }, \InvalidArgumentException::class);
    }

    public function test_delete_backup_object_if_exist_success()
    {
        // arrange
        $backupObjectCreated = BackupObject::factory(2)->create();

        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $isDelete = $service->deleteBackupObject($backupObjectCreated[0]->id);

        // assert
        $this->assertDatabaseCount(BackupObject::class, 1);
        $this->assertTrue($isDelete);
    }

    public function test_delete_backup_object_if_not_exist_success()
    {
        // arrange
        /** @var BackupObjectService $service */
        $service = $this->app->make(BackupObjectService::class);

        // act
        $isDelete = $service->deleteBackupObject(random_int(1,100));

        // assert
        $this->assertDatabaseCount(BackupObject::class, 0);
        $this->assertFalse($isDelete);
    }
}
