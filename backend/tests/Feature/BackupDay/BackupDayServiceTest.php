<?php

namespace Tests\Feature\BackupDay;

use App\Models\BackupDay;
use App\Services\BackupDayService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackupDayServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupDayServiceTest
     *
     * @return void
     */
    public function test_create_backup_day_success()
    {
        // arrange
        $data = ['name' => 'new backup day'];

        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->createBackupDay($data);

        // assert
        $this->assertEquals($day->name, $data['name']);
        $this->assertEquals($day->description, null);
    }

    public function test_create_backup_day_with_description_success(): void
    {
        // arrange
        $data = ['name' => 'new backup day', 'description' => 'some description'];

        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->createBackupDay($data);

        // assert
        $this->assertEquals($day->name, $data['name']);
        $this->assertEquals($day->description, $data['description']);
    }

    public function test_create_backup_day_if_field_name_is_empty_fail(): void
    {
        // arrange
        $data = [];

        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createBackupDay($data);
        }, QueryException::class);
    }

    public function test_read_backup_day_if_exist_success(): void
    {
        // arrange
        $dayCreated = BackupDay::factory()->create();

        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->getBackupDayById($dayCreated->id);

        // assert
        $this->assertEquals($day->id, $dayCreated->id);
        $this->assertEquals($day->name, $dayCreated->name);
        $this->assertEquals($day->description, $dayCreated->description);
    }

    public function test_read_backup_day_if_not_exist_success(): void
    {
        // arrange
        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->getBackupDayById(random_int(1, 100));

        // assert
        $this->assertNull($day);
    }

    public function test_update_backup_day_success(): void
    {
        // arrange
        $dayCreated = BackupDay::factory()->create();

        $dateForUpdate = [
            'name' => 'updated name',
        ];

        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->updateBackupDay($dayCreated->id, $dateForUpdate);

        // assert
        $this->assertEquals($day->id, $dayCreated->id);
        $this->assertNotEquals($day->name, $dayCreated->name);
        $this->assertEquals($day->description, $dayCreated->description);
    }

    public function test_update_backup_day_if_not_found_return_null(): void
    {
        // arrange
        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->updateBackupDay(random_int(1, 100), []);

        // assert
        $this->assertNull($day);
    }

    public function test_delete_backup_day_if_exist_return_true(): void
    {
        // arrange
        $days = BackupDay::factory(2)->create();

        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->deleteBackupDay($days[0]->id);

        // assert
        $this->assertTrue($day);
        $this->assertDatabaseCount(BackupDay::class, 1);
    }

    public function test_delete_backup_day_if_not_exist_return_false(): void
    {
        // arrange
        /** @var BackupDayService $service */
        $service = $this->app->make(BackupDayService::class);

        // act
        $day = $service->deleteBackupDay(random_int(1, 100));

        // assert
        $this->assertFalse($day);
    }
}
