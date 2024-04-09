<?php

namespace Tests\Feature\Organization;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class OrganizationControllerTest extends TestCase
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
     * clear && vendor/bin/phpunit --filter=OrganizationControllerTest
     *
     * @return void
     * @throws \Throwable
     */
    public function test_store_organization_controller_success(): void
    {
        // arrange
        $data = ['name' => 'new organization'];
        $this->withExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/organizations', $data);
        $res = $response->decodeResponseJson();

        // assert
        $response->assertStatus(201);
        $response->assertJson(['status' => true]);
        $this->assertEquals($res['data'][0]['name'], $data['name']);
    }

    public function test_store_organization_controller_required_name_field(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->post('admin/organizations');

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'Название организации обязателено!',
        ]);
    }

    public function test_store_organization_controller_unique_failed(): void
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $organization = Organization::factory()->create();

        // act
        $response = $this->post('admin/organizations', ['name'=>$organization->name]);

        // assert
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'name' => 'Такая организация уже существует!',
        ]);
    }

    public function test_get_organizations_collection_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $organization = Organization::factory(10)->create();

        // act
        $response = $this->get('admin/organization-all-paginate?limit=10');
        $result = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertEquals($result['count'], $organization->count());
    }

    public function test_delete_organization_by_id_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $organization = Organization::factory()->create();

        // act
        $response = $this->delete('admin/organizations/' . $organization->id);
        $result = $response->decodeResponseJson();

        // assets
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertTrue($result['data'][0]);
    }

    public function test_get_organization_by_id_success()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $organization = Organization::factory()->create();

        // act
        $response = $this->get('admin/organizations/' . $organization->id);
        $result = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertEquals($result['data']['organization']['id'], $organization->id);
    }

    public function test_get_organization_by_id_if_not_exist()
    {
        // arrange
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // act
        $response = $this->get('admin/organizations/' . random_int(1, 10));
        $result = $response->decodeResponseJson();

        // assert
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertNull($result['data']['organization']);
        $this->assertFalse($result['status']);
    }
}
