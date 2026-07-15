<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email_address' => fake()->unique()->safeEmail(),
            'mobile_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'status' => 'active',
        ];
    }
}
