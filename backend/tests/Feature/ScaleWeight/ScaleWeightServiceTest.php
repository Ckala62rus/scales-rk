<?php

namespace Tests\Feature\ScaleWeight;

use App\Contracts\Scale\ScaleServiceInterface;
use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Models\Scale;
use App\Models\ScaleWeight;
use Database\Factories\ScaleFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScaleWeightServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=ScaleWeightServiceTest
     *
     * @return void
     */
    public function test_create_scale_weight_success(): void
    {
        // arrange
        $scale = Scale::factory()->create();

        $dataPrepare = [
            'weight' => 0.40,
            "scale_id" => $scale->id,
        ];

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);


        // act
        $scaleWeight = $scaleWeightService
            ->createScaleWeight($dataPrepare);

        // assert
        $this->assertEquals($scaleWeight->scale_id, $scale->id);
        $this->assertEquals($scaleWeight->scale->id, $scale->id);
    }

    public function test_create_scale_without_weight_fail(): void
    {
        // arrange
        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        // act
        // assert
        $this->assertThrows(function() use($scaleWeightService){
            $scaleWeightService->createScaleWeight([]);
        });
    }

    public function test_create_scale_without_scale_id_fail(): void
    {
        // arrange
        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        // act
        // assert
        $this->assertThrows(function() use($scaleWeightService){
            $scaleWeightService->createScaleWeight(["weight" => 0.100]);
        });
    }

    public function test_get_scale_weight_by_id_success(): void
    {
        // arrange
        $scale = Scale::factory()->create();
        $scaleWeight = ScaleWeight::factory()->create(['scale_id' => $scale->id]);

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        // act
        $scaleWeightById = $scaleWeightService->getScaleWeightById($scaleWeight->id);

        // assert
        $this->assertEquals($scaleWeightById->id, $scaleWeight->id);
        $this->assertEquals($scaleWeightById->scale->id, $scale->id);
    }

    public function test_get_scale_weight_by_id_if_not_exists_fail(): void
    {
        // arrange
        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        // act
        $scaleWeightById = $scaleWeightService->getScaleWeightById(random_int(1, 100));

        // assert
        $this->assertNull($scaleWeightById);
    }

    public function test_scale_weight_delete_cascade_success(): void
    {
        // arrange
        $scale = Scale::factory()->create();
        $scaleWeight = ScaleWeight::factory(10)->create(['scale_id' => $scale->id]);

        /** @var ScaleServiceInterface $scaleService */
        $scaleService = $this
            ->app
            ->make(ScaleServiceInterface::class);

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        // act
        $scaleById = $scaleService->getScaleById($scale->id);
        $scaleWeightEntitiesBeforeDelete = count($scaleById->scales_weight);

        $scaleService->deleteScale($scale->id);
        $scaleByIdAfterDelete = $scaleService->getScaleById($scale->id);

        $scalesWeightEntitiesAfterDelete = $scaleWeightService
            ->getAllScalesWeightCollection(["scale_id" => $scale->id]);

        // assert
        $this->assertDatabaseCount(ScaleWeight::class, 0);
        $this->assertNull($scaleByIdAfterDelete);
        $this->assertEquals($scalesWeightEntitiesAfterDelete->count(), 0);
    }

    public function test_scale_weight_delete_one_record_success(): void
    {
        // arrange
        $scale = Scale::factory()->create();
        $scaleWeight = ScaleWeight::factory(10)->create(['scale_id' => $scale->id]);

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        // act
        $randomId = random_int(0, 9);
        $scaleWeightService->deleteScaleWeight($scaleWeight[$randomId]->delete());
        $scaleWeightCollectionAfterDelete = $scaleWeightService
            ->getAllScalesWeightCollection(["scale_id" => $scale->id]);
        $scaleWeightByIdAfterDelete = $scaleWeightService
            ->getScaleWeightById($randomId);

        // assert
        $this->assertEquals($scaleWeightCollectionAfterDelete->count(), 9);
        $this->assertDatabaseCount(ScaleWeight::class, 9);
        $this->assertNull($scaleWeightByIdAfterDelete);
    }
}
