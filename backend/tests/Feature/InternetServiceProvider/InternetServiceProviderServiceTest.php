<?php

namespace Tests\Feature\InternetServiceProvider;

use App\Models\ChannelType;
use App\Models\InternetServiceProvider;
use App\Models\InternetSpeed;
use App\Models\Organization;
use App\Models\User;
use App\Services\InternetServiceProviderService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InternetServiceProviderServiceTest extends TestCase
{
    use DatabaseTransactions;

    private function getData(User $user = null): array
    {
        return [
            'organization_id' => Organization::factory()->create(['name' => 'my organization'])->id, // required
            'address' => '123100, Москва, Пресненская набережная, дом 12 Башня Федерация', // required
            'internet_speed_id' => InternetSpeed::factory()->create(['name' => '100Мбит'])->id,
            'channel_type_id' => ChannelType::factory()->create(['name' => 'some channel type'])->id, // required
            'static_ip_address' => 'some ip address and some text',
            'schema_org_channel_provider' => fake()->text(100),
            'cost_participant_1' => fake()->text(255),
            'cost_participant_2' => fake()->text(255),
            'cost_participant_3' => fake()->text(255),
            'cost_participant_4' => fake()->text(255),
            'cost_participant_5' => fake()->text(255),
            'cost_participant_6' => fake()->text(255),
            'comment' => fake()->text(255),
            'user_id' => $user ?? User::factory()->create()->id,
        ];
    }

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=InternetServiceProviderServiceTest
     *
     * @return void
     * @throws Exception
     */
    public function test_create_internet_service_provider_success(): void
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getData($user);

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $isp = $service->createInternetServiceProvider($data);

        // assert
        $this->assertEquals($data['organization_id'], $isp->organization->id);
        $this->assertEquals($user->id, $isp->user->id);
        $this->assertEquals($data['channel_type_id'], $isp->channel_type->id);
        $this->assertEquals($data['internet_speed_id'], $isp->internet_speed->id);
    }

    public function test_create_internet_service_provider_without_organization_id_field_fail(): void
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getData($user);
        unset($data['organization_id']);

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createInternetServiceProvider($data);
        }, QueryException::class);
    }

    public function test_create_internet_service_provider_without_address_field_fail(): void
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getData($user);
        unset($data['address']);

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createInternetServiceProvider($data);
        }, QueryException::class);
    }

    public function test_create_internet_service_provider_without_channel_type_id_field_fail(): void
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = $this->getData($user);
        unset($data['channel_type_id']);

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        // assert
        $this->assertThrows(function() use ($service, $data) {
            $service
                ->createInternetServiceProvider($data);
        }, QueryException::class);
    }

    public function test_read_internet_service_provider_by_id_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $isp = $service->getInternetServiceProviderById($ispCreated->id);

        // assert
        $this->assertEquals($ispCreated->id, $isp->id);
        $this->assertEquals($ispCreated->organization_id, $isp->organization_id);
        $this->assertEquals($ispCreated->user_id, $isp->user_id);
        $this->assertEquals($ispCreated->channel_type_id, $isp->channel_type_id);
    }

    public function test_read_internet_service_provider_by_id_if_not_exist(): void
    {
        // arrange
        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $isp = $service->getInternetServiceProviderById(random_int(1, 100));

        // assert
        $this->assertNull($isp);
    }

    public function test_update_address_internet_service_provider_by_id_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $ispUpdated = $service->updateInternetServiceProvider($ispCreated->id, [
            'address' => 'new address',
        ]);

        // assert
        $this->assertEquals($ispCreated->id, $ispUpdated->id);
        $this->assertNotEquals($ispCreated->address, $ispUpdated->address);
    }

    public function test_update_channel_type_id_internet_service_provider_by_id_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();
        $newChannelType = ChannelType::factory()->create();

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $ispUpdated = $service->updateInternetServiceProvider($ispCreated->id, [
            'channel_type_id' => $newChannelType->id,
        ]);

        // assert
        $this->assertEquals($ispCreated->id, $ispUpdated->id);
        $this->assertNotEquals($ispCreated->channel_type_id, $ispUpdated->channel_type_id);
        $this->assertEquals($ispUpdated->channel_type_id, $newChannelType->id);
    }

    public function test_update_organization_id_internet_service_provider_by_id_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();
        $newOrganization = Organization::factory()->create();

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $ispUpdated = $service->updateInternetServiceProvider($ispCreated->id, [
            'organization_id' => $newOrganization->id,
        ]);

        // assert
        $this->assertEquals($ispCreated->id, $ispUpdated->id);
        $this->assertEquals($ispUpdated->organization_id, $newOrganization->id);
    }

    public function test_delete_internet_service_provider_by_id_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();

        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $isDelete = $service->deleteInternetServiceProvider($ispCreated->id);

        // assert
        $this->assertTrue($isDelete);
        $this->assertDatabaseCount(InternetServiceProvider::class, 0);
    }

    public function test_delete_internet_service_provider_by_id_if_not_exist_fail(): void
    {
        // arrange
        /** @var InternetServiceProviderService $service */
        $service = $this->app->make(InternetServiceProviderService::class);

        // act
        $isDelete = $service->deleteInternetServiceProvider(random_int(1, 100));

        // assert
        $this->assertFalse($isDelete);
        $this->assertDatabaseCount(InternetServiceProvider::class, 0);
    }
}
