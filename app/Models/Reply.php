<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['owner_id', 'body'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
