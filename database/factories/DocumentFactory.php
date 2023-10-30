<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'issue' => fake()->numberBetween(1,10),
            'uploaded_by' => fake()->numberBetween(1,2),
            'description' => fake()->text(),
            'lable' => fake()->lastName(),
            'file' => fake()->url(),
            'created_by' => fake()->numberBetween(1,2),
            'updated_by' => fake()->numberBetween(1,2),
        ];
    }
}
