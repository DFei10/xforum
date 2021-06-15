<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $with = ['author', 'channel'];

    protected $fillable = ['title', 'body', 'author_id', 'channel_id'];

    public static function booted()
    {
        static::addGlobalScope('replies_count', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public function addReply($attributes)
    {
        $this->replies()->create($attributes);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
