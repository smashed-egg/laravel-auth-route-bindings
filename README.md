<p align="center">
  <img src="https://raw.githubusercontent.com/smashed-egg/.github/05d922c99f1a3bddea88339064534566b941eca9/profile/main.jpg" width="300">
</p>

# Laravel Auth Route Bindings
[![Latest Stable Version](https://poser.pugx.org/smashed-egg/laravel-auth-route-bindings/v/stable)](https://github.com/smashed-egg/laravel-auth-route-bindings/releases)
[![Downloads this Month](https://img.shields.io/packagist/dm/smashed-egg/laravel-auth-route-bindings.svg)](https://packagist.org/packages/smashed-egg/laravel-auth-route-bindings)


This package allows you to create route model bindings that also use the authenticated user to retrieve the model.

For example. You might want to check that the Post model requested belongs to the User that's logged in. 
Previously you might have done something like the following:

```php
Route::get('posts/{post}', function (Post $post) {
    abort_unless($post->user_id === auth()->user()->getAuthIdentifier());
    return $post;
});
```

or

```php
Route::get('posts/{id}', function ($id) {
    $post = Post::where('user_id', auth()->user()->getAuthIdentifier())->findOrFail($id);
    return $post;
});
```

or using Policies:

```php
<?php
 
namespace App\Policies;
 
use App\Models\Post;
use App\Models\User;
 
class PostPolicy
{
    /**
     * Determine if the given post can be updated by the user.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
```

Policies have the disadvantage of returning data from the database, hydrating a model, then comparing, 
and in the case where the user doesn't have access to it, its then thrown away.

This package has the added benefit whereby the logic is done all at the database level.

## Requirements

* PHP 8.0.2+
* Laravel 9.0+

## Installation

To install this package please run:

```
composer require smashed-egg/laravel-auth-route-bindings
```

[Support Me](https://github.com/sponsors/tomgrohl)
--------------------------------------------

Do you like this package? Does it improve you're development. Consider sponsoring to help with future development.

[Buy me a coffee!](https://github.com/sponsors/tomgrohl)

Thank you!

## Usage

You should define your model bindings at the beginning of the boot method of your RouteServiceProvider.

For example:

```php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
 
/**
 * Define your route model bindings, pattern filters, etc.
 */
public function boot(): void
{
    Route::modelAuth('post', Post::class);
 
    // ...
}


```

And then you can use in your routes declarations the same way as you use other model bindings:

```php
Route::get('posts/{post}', function (Post $post) {
    return $post;
});
```

You can even use it with scoped bindings:

```php
Route::get('posts/{post}/comments/{comment}', function (Post $post, Comment $comment) {
    //..
})->scopeBindings();
```

So the Post must belong to the authenticated User, and the Comment must belong to the Post.