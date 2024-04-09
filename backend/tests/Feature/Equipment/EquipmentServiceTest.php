<?php

namespace Tests\Feature\Equipment;

use App\Contracts\EquipmentRepositoryInterface;
use App\Contracts\EquipmentServiceInterface;
use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Equipment;
use App\Repositories\OrganizationRepository;
use App\Services\EquipmentService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EquipmentServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=EquipmentServiceTest
     *
     * @return void
     */
    public function test_create_equipment_success()
    {
        // arrange
        $equipment = Equipment::factory()->create();

        $config = \Mockery::mock(EquipmentRepositoryInterface::class)->makePartial();
        $config
            ->shouldReceive('createEquipment')
            ->andReturn($equipment)
            ->once();

        $this->app->instance(EquipmentRepositoryInterface::class, $config);

        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $equip = $equipmentService->createEquipment(['name'=>$equipment->name]);

        // assert
        $this->assertEquals($equip->name, $equipment->name);
        $this->assertDatabaseCount(Equipment::class,1);
    }

    public function test_create_equipment_with_name_failed()
    {
        // arrange
        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        // assert
        $this->assertThrows(function() use ($equipmentService) {
            $equipmentService->createEquipment([]);
        }, QueryException::class);
    }

    public function test_get_equipment_by_id_success()
    {
        // arrange
        $equipment = Equipment::factory()->create();

        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $equip = $equipmentService->getEquipmentById($equipment->id);

        // assert
        $this->assertEquals($equip->id, $equipment->id);
        $this->assertEquals($equip->name, $equipment->name);
        $this->assertDatabaseCount(Equipment::class,1);
    }

    public function test_get_equipment_by_id_if_not_exist_failed()
    {
        // arrange
        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $quipment = $equipmentService->getEquipmentById(random_int (1, 100));

        // assert
        $this->assertNull($quipment);
        $this->assertDatabaseCount(Equipment::class, 0);
    }

    public function test_update_equipment_by_id_if_exist_success()
    {
        // arrange
        $equipment = Equipment::factory()->create();

        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act

        $equipmentUpdate = $equipmentService->updateEquipment($equipment->id, ['name' => 'some name']);

        // assert
        $this->assertEquals($equipmentUpdate->id, $equipment->id);
        $this->assertNotEquals($equipmentUpdate->name, $equipment->name);
        $this->assertDatabaseCount(Equipment::class, 1);
    }

    public function test_update_equipment_by_id_if_not_exist_failed()
    {
        // arrange
        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $equipmentUpdate = $equipmentService->updateEquipment(random_int (1, 100), ['name' => 'some name']);

        // assert
        $this->assertNull($equipmentUpdate);
    }

    public function test_delete_equipment_if_exist_success()
    {
        // arrange
        $equipment = Equipment::factory()->create();

        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $result = $equipmentService->deleteEquipment($equipment->id);

        // assert
        $this->assertTrue($result);
    }

    public function test_delete_equipment_if_not_exist_failed()
    {
        // arrange
        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $result = $equipmentService->deleteEquipment(random_int (1, 100));

        // assert
        $this->assertFalse($result);
    }

    public function test_get_equipments_collection()
    {
        // arrange
        $collection = Equipment::factory(random_int(1, 10))->create();

        /** @var EquipmentService $equipmentService */
        $equipmentService = $this->app->make(EquipmentService::class);

        // act
        $result = $equipmentService->getAllEquipmentsCollection();

        // assert
        $this->assertCount($collection->count(), $result);
    }
}
