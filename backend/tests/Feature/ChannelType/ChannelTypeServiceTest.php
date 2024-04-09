<?php

namespace Tests\Feature\ChannelType;

use App\Models\ChannelType;
use App\Services\ChannelTypeService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ChannelTypeServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=ChannelTypeServiceTest
     *
     * @return void
     */
    public function test_service_channel_type_create_success(): void
    {
        // arrange
        $data = ['name' => 'new channel type'];

        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $channelType = $service->createChannelType($data);

        // assert
        $this->assertEquals($data['name'], $channelType->name);
        $this->assertEquals(null, $channelType->description);
    }

    public function test_service_channel_type_create_without_required_field_name(): void
    {
        // arrange
        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service) {
            $service
                ->createChannelType([]);
        }, QueryException::class);
    }

    public function test_service_channel_type_show_success(): void
    {
        // arrange
        $channelTypeCreated = ChannelType::factory()->create();

        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $model = $service->getChannelTypeById($channelTypeCreated->id);

        // assert
        $this->assertEquals($channelTypeCreated->id, $model->id);
        $this->assertEquals($channelTypeCreated->name, $model->name);
        $this->assertEquals($channelTypeCreated->description, $model->description);
    }

    public function test_service_channel_type_show_not_found_fail(): void
    {
        // arrange
        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $model = $service->getChannelTypeById(random_int(1, 100));

        // assert
        $this->assertNull($model);
    }

    public function test_service_channel_type_update_success(): void
    {
        // arrange
        $dataForUpdate = [
            'name' => 'some channel type',
            'description' => 'some description channel type',
        ];

        $channelTypeCreated = ChannelType::factory()->create();

        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $model = $service->updateChannelType($channelTypeCreated->id, $dataForUpdate);

        // assert
        $this->assertEquals($channelTypeCreated->id, $model->id);
        $this->assertNotEquals($channelTypeCreated->name, $model->name);
        $this->assertNotEquals($channelTypeCreated->description, $model->description);
    }

    public function test_service_channel_type_update_only_description_success(): void
    {
        // arrange
        $dataForUpdate = [
            'description' => 'some description channel type',
        ];

        $channelTypeCreated = ChannelType::factory()->create();

        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $model = $service->updateChannelType($channelTypeCreated->id, $dataForUpdate);

        // assert
        $this->assertEquals($channelTypeCreated->id, $model->id);
        $this->assertNotEquals($channelTypeCreated->description, $model->description);
    }

    public function test_service_channel_type_delete_by_id_success(): void
    {
        // arrange
        $channelTypeCreated = ChannelType::factory()->create();

        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $isDelete = $service->deleteChannelType($channelTypeCreated->id);

        // assert
        $this->assertTrue($isDelete);
    }

    public function test_service_channel_type_delete_by_id_if_not_exist(): void
    {
        // arrange
        /** @var ChannelTypeService $service */
        $service = $this->app->make(ChannelTypeService::class);

        // act
        $isDelete = $service->deleteChannelType(random_int(1, 100));

        // assert
        $this->assertFalse($isDelete);
    }
}
