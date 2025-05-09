<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::find(1)->id ?? null,
            'category_id' => Category::inRandomOrder()->first()->id ?? null,
            'location_id' => City::inRandomOrder()->first()->id ?? null,
            'company_id' => Company::inRandomOrder()->first()->id ?? null,
            'tittle' => fake()->jobTitle,
            'description' => fake()->paragraph,
            'type' => fake()->randomElement(['Full-Time', 'Part-time', 'Remote']),
            'salary' => fake()->numberBetween(400, 2000),
            'nrWorkers' => fake()->numberBetween(1, 10),
            'expiration_date' => fake()->dateTimeBetween('+7 days', '+1 year')->format('Y-m-d'),
        ];
    }
}
