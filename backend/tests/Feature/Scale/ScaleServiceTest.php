<?php

namespace Tests\Feature\Scale;

use App\Contracts\Scale\ScaleServiceInterface;
use App\Models\Scale;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ScaleServiceTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=ScaleServiceTest
     *
     * @return void
     */
    public function test_create_scale_success(): void
    {
        // arrange
        $data = [
            "ip_address" => "127.0.0.1",
            "port" => "5001",
        ];

        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        $scale = $service->createScale($data);

        // assert
        $this->assertEquals($scale->ip_address, $data["ip_address"]);
        $this->assertEquals($scale->port, $data["port"]);
    }

    public function test_create_scale_without_port_failed(): void
    {
        // arrange
        $data = [
            "ip_address" => "127.0.0.1",
        ];

        // act
        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        // assert
        $this->assertThrows(function() use($service, $data){
            $service->createScale($data);
        });
    }

    public function test_create_scale_without_ip_address_failed(): void
    {
        // arrange
        $data = [
            "port" => 5001,
        ];

        // act
        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        // assert
        $this->assertThrows(function() use($service, $data){
            $service->createScale($data);
        });
    }

    public function test_get_scale_by_id_if_exists_success(): void
    {
        // arrange
        $scale = Scale::factory()->create();

        // act
        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);
        $scalesById = $service->getScaleById($scale->id);

        // assert
        $this->assertEquals($scalesById->ip_address, $scale->ip_address);
        $this->assertEquals($scalesById->port, $scale->port);
    }

    public function test_get_scale_by_id_if_not_exist_exists_fail(): void
    {
        // arrange
        // act
        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);
        $scalesById = $service->getScaleById(rand(1, 100));

        // assert
        $this->assertNull($scalesById);
    }

    public function test_update_scale_by_id_if_exists_scale_success(): void
    {
        // arrange
        $data = [
            "ip_address" => "127.0.0.1"
        ];

        $scale = Scale::factory()->create();

        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        $scaleBeforeUpdate = $service->getScaleById($scale->id);
        $scaleAfterUpdate = $service->updateScale($scale->id, ["ip_address" => $data["ip_address"]]);

        // assert
        $this->assertEquals($scaleAfterUpdate->ip_address, $data["ip_address"]);
        $this->assertNotEquals($scaleBeforeUpdate->ip_address, $data["ip_address"]);
    }

    public function test_update_scale_by_id_if_not_exists_scale_fail(): void
    {
        // arrange

        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        // assert
        $this->assertThrows(function() use($service){
            $service->updateScale(rand(1, 100), []);
        }, NotFoundHttpException::class);
    }

    public function test_delete_scale_by_id_if_exists_scale_success(): void
    {
        // arrange
        $scale = Scale::factory()->create();

        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        $isDeleted = $service->deleteScale($scale->id);

        // assert
        $this->assertTrue($isDeleted);
    }

    public function test_delete_scale_by_id_if_not_exists_scale_success(): void
    {
        // arrange
        /** @var ScaleServiceInterface $service */
        $service = $this->app->make(ScaleServiceInterface::class);

        // act
        $isDeleted = $service->deleteScale(rand(1, 100));

        // assert
        $this->assertFalse($isDeleted);
    }
}
