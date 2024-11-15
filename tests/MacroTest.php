<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use SmashedEgg\LaravelAuthRouteBindings\RouteBindingServiceProvider;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\Comment;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\Post;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Models\User;

/**
 * @internal
 *
 * @coversNothing
 */
class MacroTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Route::modelAuth('userPost', Post::class);
    }

    public function testMacroExists(): void
    {
        $this->assertTrue(Route::hasMacro('modelAuth'));
    }

    public function testMacroWorksForUser(): void
    {
        $user = User::factory()->createOne();
        $user2 = User::factory()->createOne();

        $post = Post::factory()->forUser($user)->createOne();
        $post2 = Post::factory()->forUser($user2)->createOne();

        $unitTest = $this;

        Route::group(['middleware' => 'web'], function () use ($post, $unitTest) {
            Route::get('posts/{userPost}', function (Post $userPost) use ($post, $unitTest) {
                $unitTest->assertEquals($post->getKey(), $userPost->getKey());
            });
        });

        $this->actingAs($user, 'web');

        $response = $this->get('posts/'.$post->getKey());
        $response->assertOk();

        $response2 = $this->get('posts/'.$post2->getKey());
        $response2->assertNotFound();
    }

    public function testMacroWorksForUserAndScopedBindings(): void
    {
        $user = User::factory()->createOne();
        $post = Post::factory()->forUser($user)->createOne();
        $factoryComment = Comment::factory()->forPost($post)->createOne();

        $unitTest = $this;

        Route::group(['middleware' => 'web'], function () use ($unitTest, $factoryComment) {
            Route::get('posts/{post}/comments/{comment}', function (Post $post, Comment $comment) use ($unitTest, $factoryComment) {
                $unitTest->assertEquals($factoryComment->getKey(), $comment->getKey());
            })->scopeBindings();
        });

        $this->actingAs($user, 'web');

        $response = $this->get('posts/'.$post->getKey().'/comments/'.$factoryComment->getKey());
        $response->assertOk();
    }

    /**
     * @param mixed $app
     *
     * @return list<non-empty-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            TestingServiceProvider::class,
            RouteBindingServiceProvider::class,
        ];
    }
}
