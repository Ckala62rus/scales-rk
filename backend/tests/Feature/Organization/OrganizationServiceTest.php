<?php

namespace Tests\Feature\Organization;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;
use App\Services\OrganizationsService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrganizationServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     * clear && vendor/bin/phpunit --filter=OrganizationServiceTest
     *
     * @return void
     */
    public function test_create_organization_success()
    {
        // arrange
        $organization = Organization::factory()->create();

        $config = \Mockery::mock(OrganizationRepositoryInterface::class)->makePartial();
        $config
            ->shouldReceive('createOrganization')
            ->andReturn($organization)
            ->once();

        $this->app->instance(OrganizationRepositoryInterface::class, $config);

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $organizationCreated = $organizationService->createOrganizations([
            'name' => $organization->name,
            'description' => $organization->description,
        ]);

        // assert
        $this->assertEquals($organizationCreated->name, $organization->name);
        $this->assertEquals($organizationCreated->description, $organization->description);
    }

    public function test_create_organization_with_name_failed()
    {
        // arrange
        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        // assert
        $this->assertThrows(function() use ($organizationService) {
            $organizationService->createOrganizations([]);
        }, QueryException::class);
    }

    public function test_create_organization_with_description_success()
    {
        // arrange
        $data = ['name' => "some name"];

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $organization = $organizationService->createOrganizations($data);

        // assert
        $this->assertEquals($organization->name, $data['name']);
        $this->assertEquals($organization->description, '');
    }

    public function test_get_organization_by_id_success()
    {
        // arrange
        $organization = Organization::factory()->create();

        $config = \Mockery::mock(OrganizationRepositoryInterface::class)->makePartial();
        $config
            ->shouldReceive('getOrganizationById')
            ->andReturn($organization)
            ->once();

        $this->app->instance(OrganizationRepositoryInterface::class, $config);

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $organizationById = $organizationService->getOrganizationsById($organization->id);

        // assert
        $this->assertEquals($organizationById->id, $organization->id);
        $this->assertEquals($organizationById->name, $organization->name);
    }

    public function test_get_organization_by_id_not_found()
    {
        // arrange
        $config = \Mockery::mock(OrganizationRepositoryInterface::class)->makePartial();
        $config
            ->shouldReceive('getOrganizationById')
            ->andReturn(null)
            ->once();

        $this->app->instance(OrganizationRepositoryInterface::class, $config);

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $organization = $organizationService->getOrganizationsById(random_int (1, 100));

        // assert
        $this->assertNull($organization);
    }

    public function test_update_organization_by_id_if_exist_success()
    {
        // arrange
        $org = Organization::factory()->create();

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $organizationUpdate = $organizationService->updateOrganizations($org->id, ['name' => 'new name']);

        // assert
        $this->assertNotEquals($organizationUpdate->name, $org->name);
        $this->assertEquals($organizationUpdate->id, $org->id);
    }

    public function test_update_organization_by_id_if_not_exist_fail()
    {
        // arrange
        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $organizationUpdate = $organizationService->updateOrganizations(random_int (1, 100), ['name' => 'new name']);

        // assert
        $this->assertNull($organizationUpdate);
    }

    public function test_delete_organization_by_id_if_exist_success()
    {
        // arrange
        $org = Organization::factory()->create();

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act

        $result = $organizationService->deleteOrganizations($org->id);

        // assert
        $this->assertTrue($result);
    }

    public function test_delete_organization_by_id_if_not_exist_fail()
    {
        // arrange
        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act

        $result = $organizationService->deleteOrganizations(random_int (1, 100));

        // assert
        $this->assertFalse($result);
    }

    public function test_get_organization_collection()
    {
        // arrange
        $collection = Organization::factory(random_int (1, 10))->create();

        /** @var  OrganizationsService $organizationService */
        $organizationService = $this->app->make(OrganizationsService::class);

        // act
        $result = $organizationService->getAllOrganizationsCollection();

        // assert
        $this->assertCount($collection->count(), $result);
    }
}
