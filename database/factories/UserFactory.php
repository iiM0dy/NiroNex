<?php

namespace Database\Factories;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'phone' => fake()->phoneNumber(),
            'birthday' => fake()->date('Y-m-d', '2005-01-01'),
            'image' => fake()->imageUrl(),
            'id_photo_type' => null,
            'id_photo_front' => fake()->imageUrl(),
            'id_photo_back' => fake()->imageUrl(),
            'selfie_photo' => fake()->imageUrl(),
            'type' => UserType::User,
            'status' => UserStatus::Pending,
            'plan_id' => Plan::inRandomOrder()->first()?->id ?? 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => UserType::Admin,
        ]);
    }

    public function withPlan(int $planId): static
    {
        return $this->state(fn(array $attributes) => [
            'plan_id' => $planId,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => UserStatus::Active,
        ]);
    }
}
