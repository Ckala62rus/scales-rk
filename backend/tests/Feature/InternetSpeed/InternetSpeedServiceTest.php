<?php

namespace Tests\Feature\InternetSpeed;

use App\Models\InternetSpeed;
use App\Services\InternetSpeedService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InternetSpeedServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=InternetSpeedServiceTest
     *
     * @return void
     */
    public function test_create_internet_speed_success(): void
    {
        // arrange
        $data = [
            'name' => '100mb/s'
        ];

        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $internetSpeedCreated = $service->createInternetSpeed($data);

        // assert
        $this->assertEquals($internetSpeedCreated->name, $data['name']);
        $this->assertEquals($internetSpeedCreated->description, null);
    }

    public function test_create_internet_speed_with_description(): void
    {
        // arrange
        $data = [
            'name' => '100mb/s',
            'description' => 'some text',
        ];

        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $internetSpeedCreated = $service->createInternetSpeed($data);

        // assert
        $this->assertEquals($internetSpeedCreated->name, $data['name']);
        $this->assertEquals($internetSpeedCreated->description, $data['description']);
    }

    public function test_create_internet_speed_fail(): void
    {
        // arrange
        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        // assert
        $this->assertThrows(function() use($service){
            $service->createInternetSpeed([]);
        });
    }

    public function test_read_internet_speed_by_id_success(): void
    {
        // arrange
        $internetSpeedCreated = InternetSpeed::factory()->create();

        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $internetSpeed = $service->getInternetSpeedById($internetSpeedCreated->id);

        // assert
        $this->assertEquals($internetSpeed->id, $internetSpeedCreated->id);
        $this->assertEquals($internetSpeed->name, $internetSpeedCreated->name);
        $this->assertEquals($internetSpeed->description, $internetSpeedCreated->description);
    }

    public function test_read_internet_speed_by_id_if_not_exist_return_null(): void
    {
        // arrange
        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $notFound = $service->getInternetSpeedById(random_int(1,100));

        // assert
        $this->assertNull($notFound);
    }

    public function test_update_internet_speed_entity_by_id_success(): void
    {
        // arrange
        $internetSpeedCreated = InternetSpeed::factory()->create();
        $oldName = $internetSpeedCreated->name;
        $dateForUpdate = ['name' => 'updated name'];

        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $internetSpeedUpdated = $service->updateInternetSpeed($internetSpeedCreated->id, $dateForUpdate);

        // assert
        $this->assertEquals($internetSpeedCreated->id, $internetSpeedUpdated->id);
        $this->assertNotEquals($internetSpeedUpdated->name, $internetSpeedCreated->name);
    }

    public function test_delete_internet_speed_if_exist_database_success(): void
    {
        // arrange
        $internetSpeedCreated = InternetSpeed::factory()->create();

        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $isDelete = $service->deleteInternetSpeed($internetSpeedCreated->id);

        // assert
        $this->assertTrue($isDelete);
    }

    public function test_delete_internet_speed_if_not_exist_database_fail(): void
    {
        // arrange
        /** @var InternetSpeedService $service */
        $service = $this->app->make(InternetSpeedService::class);

        // act
        $isDelete = $service->deleteInternetSpeed(random_int(1,100));

        // assert
        $this->assertFalse($isDelete);
    }
}
