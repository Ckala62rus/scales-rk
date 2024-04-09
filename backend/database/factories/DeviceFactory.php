<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Equipment;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class DeviceFactory extends Factory
{
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'hostname' => fake()->slug,
            'model' => fake()->text(10),
            'date_buy'  => fake()->date(),
            'description_service' => fake()->text(10),
            'date_update'  => fake()->date,
            'operation_system' => fake()->text(10),
            'cpu' => fake()->text(10),
            'count_core' => fake()->numberBetween(1, 10),
            'count_core_with_ht' => fake()->numberBetween(1, 10),
            'memory' => fake()->numberBetween(2, 1024),
            'hdd' => fake()->numberBetween(2, 1024),
            'ssd' => fake()->numberBetween(2, 1024),
            'address' => fake()->address,
            'comment' => fake()->text(10),
            'user_id' => User::factory()->create(),
            'organization_id' => Organization::factory()->create(),
            'equipment_id' => Equipment::factory()->create(),
        ];
    }
}
