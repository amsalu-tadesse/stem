<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkingGroup>
 */
class WorkingGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'organization_level_id' => fake()->numberBetween(1,10),
            'current_secretariat' => fake()->numberBetween(1,10),
            'created_by' => fake()->numberBetween(1,2),
            'updated_by' => fake()->numberBetween(1,2),
        ];
    }
}
