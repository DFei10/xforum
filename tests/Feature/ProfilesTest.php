<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = $this->create(User::class);

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn();

        $user = $this->create(User::class);

        $thread = $this->create(Thread::class, ['author_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($thread->title);
    }

    /** @test */
    public function it_fetches_activity_feed_for_any_user()
    {
        $this->signIn();

        $this->create(Thread::class, ['author_id' => auth()->id()], 2);
        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subweek()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subweek()->format('Y-m-d')
        ));
    }
}
