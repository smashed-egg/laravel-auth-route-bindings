<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Factories\PostFactory;

class Post extends Model
{
    /** @use HasFactory<\SmashedEgg\LaravelAuthRouteBindings\Tests\Factories\PostFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'body',
        'user_id',
    ];

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected static function newFactory(): PostFactory
    {
        return new PostFactory();
    }
}
