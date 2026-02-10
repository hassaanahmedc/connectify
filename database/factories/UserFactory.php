<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fname' => fake()->firstName(),
            'lname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'cover' => fake()->boolean(20) ? fake()->imageUrl(1200, 300, 'nature', true) : null, // 20% chance of having a cover photo
            'avatar' => fake()->boolean(70) ? fake()->imageUrl(200, 200, 'people', true) : null, // 70% chance of having an avatar
            'bio' => fake()->boolean(50) ? fake()->paragraph(3) : null, // 50% chance of having a bio
            'location' => fake()->boolean(60) ? fake()->city() : null, // 60% chance of having a location
            'website' => fake()->boolean(30) ? fake()->url() : null, // 30% chance of having a website
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
