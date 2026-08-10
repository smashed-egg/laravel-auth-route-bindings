<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Factories\CommentFactory;

class Comment extends Model
{
    /** @use HasFactory<\SmashedEgg\LaravelAuthRouteBindings\Tests\Factories\CommentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'comment',
        'post_id',
    ];

    protected static function newFactory(): CommentFactory
    {
        return new CommentFactory();
    }
}
