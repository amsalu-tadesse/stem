<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'private_benefit' => fake()->text(),
            'public_benefit' => fake()->text(),
            'responsible_institution' => fake()->numberBetween(1,10),
            'responsible_person' => fake()->numberBetween(1,2),
            'kpi' => fake()->numberBetween(1,10),

            'issue_level' => fake()->numberBetween(1,10),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'created_by' => fake()->numberBetween(1,2),
            'updated_by' => fake()->numberBetween(1,2),
        ];
    }
}
