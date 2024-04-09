<?php

namespace Tests\Feature\InternetServiceProvider;

use App\Models\ChannelType;
use App\Models\InternetServiceProvider;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;
use Throwable;

class InternetServiceProviderControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=InternetServiceProviderControllerTest
     *
     * @return void
     * @throws Throwable
     */
    public function test_controller_store_isp_success(): void
    {
        // arrange
        $organization   = Organization::factory()->create(['name' => 'my organization']); // required
        $address        = '123100, Москва, Пресненская набережная, дом 12 Башня Федерация'; // required
        $channelType    = ChannelType::factory()->create(['name' => 'some channel type']); // required

        $data = [
            'organization_id' => $organization->id,
            'address' => $address,
            'channel_type_id' => $channelType->id,
        ];

        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/isp', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isp' => [
                    'organization_id' => $organization->id,
                    'user' =>
                        [
                            'name' => $user->name
                        ],
                    'address' => $address,
                    'channel_type_id' => $channelType->id,
                ],
            ]
        ]);
    }

    public function test_controller_store_isp_without_organization_id_fail(): void
    {
        // arrange
        $address        = '123100, Москва, Пресненская набережная, дом 12 Башня Федерация'; // required
        $channelType    = ChannelType::factory()->create(['name' => 'some channel type']); // required

        $data = [
            'address' => $address,
            'channel_type_id' => $channelType->id,
        ];

        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/isp', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'organization_id' => 'The organization id field is required.',
        ]);
    }

    public function test_controller_store_isp_without_address_id_fail(): void
    {
        // arrange
        $organization   = Organization::factory()->create(['name' => 'my organization']); // required
        $channelType    = ChannelType::factory()->create(['name' => 'some channel type']); // required

        $data = [
            'organization_id' => $organization->id,
            'channel_type_id' => $channelType->id,
        ];

        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/isp', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'address' => 'The address field is required.',
        ]);
    }

    public function test_controller_store_isp_without_channel_type_id_fail(): void
    {
        // arrange
        $organization   = Organization::factory()->create(['name' => 'my organization']); // required
        $address        = '123100, Москва, Пресненская набережная, дом 12 Башня Федерация'; // required

        $data = [
            'organization_id' => $organization->id,
            'address' => $address,
        ];

        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/isp', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'channel_type_id' => 'The channel type id field is required.',
        ]);
    }

    public function test_controller_show_isp_by_id_if_exist_entity_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get("admin/isp/" . $ispCreated->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isp' => [
                    'id' => $ispCreated->id,
                    'address' => $ispCreated->address,
                    'organization' => [
                        'id' => $ispCreated->organization->id,
                        'name' => $ispCreated->organization->name,
                    ],
                    'channel_type' => [
                        'id' => $ispCreated->channel_type->id,
                        'name' => $ispCreated->channel_type->name,
                    ],
                ]
            ]
        ]);
    }

    public function test_controller_show_isp_by_id_if_not_exist_entity_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get("admin/isp/" . random_int(1, 100));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson([
            'data' => [
                'isp' => [],
            ]
        ]);
    }

    public function test_controller_update_field_organization_id_in_isp_if_exists_entity_success(): void
    {
        // arrange
        $ispCreated = InternetServiceProvider::factory()->create();
        $organization = Organization::factory()->create(['name' => 'new organization']);
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->put("admin/isp/" . $ispCreated->id, [
            'organization_id' => $organization->id,
        ]);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isp' => [
                    'id' => $ispCreated->id,
                    'organization_id' => $organization->id,
                ],
            ]
        ]);
    }

    public function test_controller_update_field_channel_type_id_in_isp_if_exists_entity_success(): void
    {
        // arrange
        $channel = ChannelType::factory()->create(['name' => 'new channel type']);
        $ispCreated = InternetServiceProvider::factory()->create();
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->put("admin/isp/" . $ispCreated->id, [
            'channel_type_id' => $channel->id,
        ]);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isp' => [
                    'id' => $ispCreated->id,
                    'channel_type_id' => $channel->id,
                ],
            ]
        ]);
    }

    public function test_controller_update_field_address_in_isp_if_exists_entity_success(): void
    {
        // arrange
        $newAddress = "some new address for update";
        $ispCreated = InternetServiceProvider::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->put("admin/isp/" . $ispCreated->id, [
            'address' => $newAddress,
        ]);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isp' => [
                    'id' => $ispCreated->id,
                    'address' => $newAddress,
                ],
            ]
        ]);
    }

    public function test_controller_delete_isp_by_id_if_exists_in_database_success(): void
    {
        // arrange
        $isp = InternetServiceProvider::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->delete("admin/isp/" . $isp->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isDelete' => true
            ]
        ]);
    }

    public function test_controller_delete_isp_by_id_if_not_exists_in_database_fail(): void
    {
        // arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->delete("admin/isp/" . random_int(1, 100));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'isDelete' => false,
            ]
        ]);
    }
}
