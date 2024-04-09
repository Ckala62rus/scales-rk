<?php

namespace Tests\Feature\Equipment;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class EquipmentControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=EquipmentControllerTest
     *
     * @return void
     * @throws \Throwable
     */
    public function test_store_equipment_controller_success(): void
    {
        // arrange
        $data = ['name' => 'server'];
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/equipments', $data);
        $res = $response->decodeResponseJson();

        // assert
        $response->assertStatus(201);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'equipment' => [
                    'name' => $data['name'],
                    'description' => null
                ]
            ]
        ]);
    }

    public function test_store_equipment_controller_if_not_name_failed(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/equipments', []);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'Название типа оборудования, обязателено!',
        ]);
    }

    public function test_store_controller_unique_failed()
    {
        // arrange
        $equipment = Equipment::factory()->create();
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/equipments', ['name' => $equipment->name]);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'Такой тип оборудования уже существует!',
        ]);
    }

    public function test_get_equipment_by_id_success()
    {
        // arrange
        $equipment = Equipment::factory()->create();
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get('admin/equipments/' . $equipment->id);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => true]);
        $response->assertJson([
            'data' => [
                'equipment' => [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'description' => $equipment->description
                ]
            ]
        ]);
    }

    public function test_get_equipment_by_id_if_not_exist()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get('admin/equipments/' . random_int(1,10));

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['status' => false]);
        $response->assertJson([
            'data' => [
                'equipment' => []
            ]
        ]);
    }

    public function test_get_equipments_collection_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $equipments = Equipment::factory(10)->create();

        // act
        $response = $this->get('admin/equipments-all-paginate?limit=10');
        $result = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertEquals($result['count'], $equipments->count());
    }

    public function test_update_equipment_controller_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $equipments = Equipment::factory()->create();

        // act
        $response = $this->put('admin/equipments/' . $equipments->id, [
            'name' => 'some name'
        ]);
        $res = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertNotEquals($res['data']['equipment']['name'], $equipments->name);
        $this->assertEquals($res['data']['equipment']['id'], $equipments->id);
    }

    public function test_delete_equipment_by_id_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $equipments = Equipment::factory()->create();

        // act
        $response = $this->delete('admin/equipments/' . $equipments->id);
        $result = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertTrue($result['data'][0]);
    }
}
