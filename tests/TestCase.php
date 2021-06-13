<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        $user = $user ?? $this->create(User::class);

        $this->be($user);

        return $this;
    }

    public function make($className, $overrides = [], $count = null)
    {
        return  $className::factory($count)->make($overrides);
    }

    public function create($className, $overrides = [], $count = null)
    {
        return $className::factory($count)->create($overrides);
    }
}
