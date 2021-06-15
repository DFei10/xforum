<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_may_not_favorite_a_reply()
    {
        $this->post('/replies/1/favorite')->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = $this->create(Reply::class);

        $this->post("/replies/{$reply->id}/favorite");

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = $this->create(Reply::class);

        $this->post("/replies/{$reply->id}/favorite");
        $this->post("/replies/{$reply->id}/favorite");

        $this->assertCount(1, $reply->favorites);
    }
}
