<?php

namespace Database\Factories;

use App\Models\Scale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScaleWeight>
 */
class ScaleWeightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "weight" => fake()->randomFloat(2, 0, 100),
            "scale_id" => Scale::factory()->create(),
        ];
    }
}
