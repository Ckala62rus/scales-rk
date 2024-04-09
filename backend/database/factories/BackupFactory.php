<?php

namespace Database\Factories;

use App\Models\Backup;
use App\Models\BackupDay;
use App\Models\BackupObject;
use App\Models\BackupTool;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backup>
 */
class BackupFactory extends Factory
{
    protected $model = Backup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'service' => fake()->slug,
            'owner' => fake()->text(10),
            'hostname' => fake()->slug,
            'backup_object_id' => BackupObject::factory()->create(),
            'backup_tool_id' => BackupTool::factory()->create(),
            'comment' => fake()->slug,
            'restricted_point' => fake()->slug,
            'description_storage' => fake()->slug,
            'backup_day_id' => BackupDay::factory()->create(),
            'time_start' =>  fake()->date(),
            'storage_server' => fake()->slug,
            'storage_server_long_time' => fake()->date(),
            'user_id' => User::factory()->create(),
            'organization_id' => Organization::factory()->create(),
        ];
    }
}
