<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];

    protected function by($name)
    {
        $user = User::whereName($name)->firstOrFail();
        $this->query->where('author_id', $user->id);
    }
}
