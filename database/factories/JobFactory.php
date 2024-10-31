<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            // 'category_id' => rand(1,5),
            'category_id' => rand(1,1),
            // 'job_type_id' => rand(1,5),
            'job_type_id' => rand(1,1),
            // 'user_id' => rand(1,2),
            'user_id' => rand(1,1),
            'vacancy' => rand(1,5),
            'salary' => rand(1,5),
            'location' => fake()->city,
            'description' => fake()->text,
            'benifits' => fake()->text,
            'responsibility' => fake()->text,
            'qualification' => fake()->text,
            'keywords' => fake()->text,
            'experiance' => rand(1,10),
            'company_name' => fake()->name,
            'company_location' => fake()->city,
            'company_website' => fake()->text,
        ];
    }
}
