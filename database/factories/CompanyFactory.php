<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
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
            'name' => fake()->company(),
            'image' => 'company/default.png',
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'email' => fake()->email(),
        ];
    }
}
