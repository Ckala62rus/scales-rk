<?php

namespace Tests\Feature\InternetSpeed;

use App\Models\InternetSpeed;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;
use Throwable;

class InternetSpeedControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=InternetSpeedControllerTest
     *
     * @return void
     * @throws Throwable
     */
    public function test_controller_method_store_success(): void
    {
        // arrange
        $data = ['name' => '100mb/c'];
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/internet-speed', $data);
        $res = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'internetSpeed' => [
                    'name' => $data['name'],
                    'description' => null
                ]
            ]
        ]);
    }

    public function test_controller_method_store_full_fields_success(): void
    {
        // arrange
        $data = ['name' => '100mb/c', 'description' => 'some text'];
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/internet-speed', $data);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'internetSpeed' => [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            ]
        ]);
    }

    public function test_controller_method_store_without_required_field_name_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/internet-speed', []);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_controller_method_show_if_exist_database_success(): void
    {
        // arrange
        $model = InternetSpeed::factory()->create();

        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get('admin/internet-speed/' . $model->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'internetSpeed' => [
                    'name' => $model->name,
                    'description' => $model->description
                ]
            ]
        ]);
    }

    public function test_controller_method_show_if_not_exist_database_success(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get('admin/internet-speed/' . random_int(1,100));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson([
            'data' => [
                'internetSpeed' => [],
            ]
        ]);
    }

    public function test_controller_method_update_success(): void
    {
        // arrange
        $modelCreated = InternetSpeed::factory()->create();
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        $dataForUpdate = [
            'name' => 'update name',
            'description' => 'update description',
        ];

        // act
        $response = $this->put('admin/internet-speed/' . $modelCreated->id, $dataForUpdate);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'internetSpeed' => [
                    'name' => $dataForUpdate['name'],
                    'description' => $dataForUpdate['description'],
                ],
            ]
        ]);
    }

    public function test_controller_method_update_field_required_fail(): void
    {
        // arrange
        $modelCreated = InternetSpeed::factory()->create();
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->put('admin/internet-speed/' . $modelCreated->id, []);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'The name field is required.',
        ]);
    }

    public function test_controller_method_destroy_if_exist_database_success(): void
    {
        // arrange
        $model = InternetSpeed::factory()->create();
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->delete('admin/internet-speed/' . $model->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'delete' => true
            ],
        ]);
    }

    public function test_controller_method_destroy_if_not_exist_in_database_fail(): void
    {
        // arrange
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->delete('admin/internet-speed/' . random_int(1, 100));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'delete' => false
            ],
        ]);
    }
}
