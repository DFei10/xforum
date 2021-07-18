<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    protected function by($name)
    {
        $user = User::whereName($name)->firstOrFail();
        $this->builder->where('author_id', $user->id);
    }

    protected function popular()
    {
        $this->builder->getQuery()->orders= [];
        $this->builder->orderByDesc('replies_count');
    }
}
