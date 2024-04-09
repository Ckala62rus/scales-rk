<?php

namespace Tests\Feature\Backup;

use App\Models\Backup;
use App\Models\Organization;
use App\Models\User;
use App\Services\BackupService;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class BackupServiceTest extends TestCase
{
    use DatabaseTransactions;

    private function getData(User $user, Organization $organization)
    {
        return [
            'user_id' => $user->id,
            'organization_id' => $organization->id,
        ];
    }

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=BackupServiceTest
     *
     * @return void
     * @throws Exception
     */
    public function test_create_backup_success(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $organization = Organization::factory()->create();

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        $data = $this->getData($user, $organization);
        $data['service'] = 'some service text';
        $data['object'] = 'some object text';

        // act
        $backup = $service->createBackup($data);

        // assert
        $this->assertEquals($backup->user_id, $data['user_id']);
        $this->assertEquals($backup->organization_id, $data['organization_id']);
    }

    /**
     * @param $data
     * @return void
     * @dataProvider invalidBackupData
     * @throws Exception
     */
    public function test_create_backup_negative($data): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service->createBackup($data);
        }, NotFoundHttpException::class);
    }

    /**
     * Service provider for test_create_backup_negative
     * @return string[][][]
     */
    public function invalidBackupData(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    'user_id' => 1
                ],
            ],
            [
                [
                    'organization_id' => 1
                ],
            ],
        ];
    }

    public function test_read_backup_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $organization = Organization::factory()->create();

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        $data = $this->getData($user, $organization);
        $data['service'] = 'some service text';
        $data['object'] = 'some object text';

        $backupCreated = $service->createBackup($data);

        // act
        $backupById = $service->getBackupById($backupCreated->id);

        // assert
        $this->assertEquals($backupById->id, $backupCreated->id);
        $this->assertEquals($backupById->user_id, $backupCreated->user_id);
        $this->assertEquals($backupById->organization_id, $backupCreated->organization_id);
    }

    public function test_delete_backup_success_if_exist_in_database()
    {
        // arrange
        $this->withExceptionHandling();
        $backups = Backup::factory(2)->create();

        $user = User::factory()->create();
        $user->syncRoles(Role::create(['name'=>'super']));
        $this->actingAs($user);

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        // act
        $isDelete = $service->deleteBackup($backups[0]->id);

        // assert
        $this->assertTrue($isDelete);
        $this->assertDatabaseCount(Backup::class, 1);
    }

    public function test_delete_backup_success_if_not_exist_in_database()
    {
        // arrange
        $user = User::factory()->create();
        $user->syncRoles(Role::create(['name'=>'super']));
        $this->actingAs($user);

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        // act
        $isDelete = $service->deleteBackup(random_int(1, 100));

        // assert
        $this->assertFalse($isDelete);
        $this->assertDatabaseCount(Backup::class, 0);
    }

    public function test_update_backup_success()
    {
        // arrange
        $backupCreated = Backup::factory()->create();

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        // act
        $backupUpdated = $service
            ->updateBackup($backupCreated->id, ['service' => 'test test']);

        // assert
        $this->assertNotEquals($backupUpdated->service, $backupCreated->service);
    }

    /**
     * @throws Exception
     */
    public function test_dont_delete_backup_if_you_didnt_create_this_backup()
    {
        // arrange
        $firstOrganization = Organization::factory()->create(['name' => 'first org']);

        $roleUser = Role::create(['name'=>'user']);

        $userFirstOrganization = User::factory()->create(['organization_id'=> $firstOrganization->id]);
        $userFirstOrganization->syncRoles($roleUser);

        $backupCreated = Backup::factory()->create([
            'organization_id'=> $firstOrganization->id,
            'user_id' => $userFirstOrganization->id,
        ]);

        $secondOrganization = Organization::factory()->create(['name' => 'second org']);

        $userSecondOrganization = User::factory()->create(['organization_id'=> $secondOrganization->id]);
        $userSecondOrganization->syncRoles($roleUser);
        $this->actingAs($userSecondOrganization);

        /** @var BackupService $service */
        $service = $this->app->make(BackupService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $backupCreated) {
            $service->deleteBackup($backupCreated->id);
        }, \InvalidArgumentException::class);
    }
}
