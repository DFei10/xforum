<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'subject_id', 'subject_type', 'created_at'];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user)
    {
        return $user->activities()
            ->with('subject')
            ->latest()
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
