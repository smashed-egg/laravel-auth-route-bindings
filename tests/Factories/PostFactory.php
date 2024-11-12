<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\Post;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\User;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * @var class-string<Post>
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text('60'),
            'body' => fake()->paragraph(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->getKey(),
        ]);
    }
}
