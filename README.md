<p align="center">
  <img src="https://raw.githubusercontent.com/smashed-egg/.github/05d922c99f1a3bddea88339064534566b941eca9/profile/main.jpg" width="300">
</p>

# Laravel Auth Route Bindings

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

## Requirements

* PHP 8.0.2+
* Laravel 9.0+

## Installation

To install this package please run:

```
composer require smashed-egg/laravel-auth-route-bindings
```
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