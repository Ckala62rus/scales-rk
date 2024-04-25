<?php

namespace Tests\Feature\ScaleApi;

use App\Contracts\Scale\ScaleApiServiceInterface;
use App\Contracts\Scale\ScaleServiceInterface;
use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Models\Scale;
use App\Models\ScaleWeight;
use App\Services\ScaleApiService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ScaleApiServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=ScaleApiServiceTest
     *
     * @return void
     */
    public function test_example()
    {
        // arrange
        $returnMockValue = 0.77;

        /** @var ScaleApiServiceInterface $scaleService */
        $ScaleApiService = $this->instance(
            ScaleApiService::class,
            Mockery::mock(ScaleApiService::class, function (MockInterface $mock) use($returnMockValue) {
                $mock
                    ->shouldReceive('getWeight')
                    ->once()
                    ->andReturn($returnMockValue);
            })
        );

        /** @var ScaleServiceInterface $scaleService */
        $scaleService = $this
            ->app
            ->make(ScaleServiceInterface::class);

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = $this
            ->app
            ->make(ScaleWeightServiceInterface::class);

        $scale = Scale::factory()->create();

        // act
        $weightFromScaleApiService = $ScaleApiService
            ->getWeight($scale->ip_address, $scale->port);
        $modelWeight = $scaleWeightService->createScaleWeight([
            "scale_id" => $scale->id,
            "weight" => $scale->port,
        ]);

        // assert
        $this->assertEquals($weightFromScaleApiService, $returnMockValue);
        $this->assertEquals($modelWeight->scale_id, $scale->id);
    }
}
