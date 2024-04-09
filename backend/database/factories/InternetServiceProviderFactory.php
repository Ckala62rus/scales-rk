<?php

namespace Database\Factories;

use App\Models\ChannelType;
use App\Models\InternetSpeed;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternetServiceProvider>
 */
class InternetServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'organization_id' => Organization::factory()->create(),
            'internet_speed_id' => InternetSpeed::factory()->create(),
            'address' => fake()->address(),
            'channel_type_id' => ChannelType::factory()->create(),
            'static_ip_address' => fake()->text('255'),
            'schema_org_channel_provider' => fake()->text('255'),
            'cost_participant_1' => fake()->text('255'),
            'cost_participant_2' => fake()->text('255'),
            'cost_participant_3' => fake()->text('255'),
            'cost_participant_4' => fake()->text('255'),
            'cost_participant_5' => fake()->text('255'),
            'cost_participant_6' => fake()->text('255'),
            'comment' => fake()->text('255'),
            'user_id' => User::factory()->create(),
            'cost' => fake()->text(255),
        ];
    }
}
