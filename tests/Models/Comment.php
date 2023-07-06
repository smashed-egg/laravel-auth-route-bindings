<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Factories\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment',
        'post_id',
    ];

    protected static function newFactory()
    {
        return new CommentFactory();
    }
}
