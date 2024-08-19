<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    public function definition(): array
    {
        return [
            // 'avatar' => null,
            'username' => fake()->userName(),
            'pseudo' => fake()->optional()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make(env('DEFAULT_USER_PASSWORD')),
            'is_private' => fake()->boolean(20),
            'remember_token' => Str::random(10),
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

    /**
     * Indicate that the model must be a super admin.
     */
    public function is_super_admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_super_admin' => true,
        ]);
    }

    /**
     * Indicate that the model must have a post.
     */
    public function withPost(): static
    {
        return $this->afterCreating(function (User $user){
            Post::create([
                'message' => fake()->text(400),
                'user_id' => $user->id
            ]);
        });
    }
}
