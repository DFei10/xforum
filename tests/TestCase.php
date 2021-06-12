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

    public function make($className, $overrides = [])
    {
        return  $className::factory()->make($overrides);
    }

    public function create($className, $overrides = [])
    {
        return $className::factory()->create($overrides);
    }
}
