<?php

namespace Database\Factories;

use App\Models\Scale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ip_address' => fake()->ipv4(),
            'port' => fake()->numberBetween(1000, 9000),
        ];
    }
}
