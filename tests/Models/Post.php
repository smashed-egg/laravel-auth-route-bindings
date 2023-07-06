<?php

namespace SmashedEgg\LaravelAuthRouteBindings\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SmashedEgg\LaravelAuthRouteBindings\Tests\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'body',
        'user_id',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function newFactory()
    {
        return new PostFactory();
    }
}
