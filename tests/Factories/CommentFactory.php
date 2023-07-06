<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\Comment;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SmashedEgg\LaravelAuthRouteBindings\Tests\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => fake()->paragraph(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function forPost(Post $post): static
    {
        return $this->state(fn (array $attributes) => [
            'post_id' => $post->getKey(),
        ]);
    }
}
