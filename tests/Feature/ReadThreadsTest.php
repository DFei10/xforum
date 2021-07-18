<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->withoutExceptionHandling();
        $thread = Thread::factory()->create();

        $this->get('/threads')
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = Thread::factory()->create();

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create(['thread_id' => $thread->id]);

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $thread = Thread::factory()->create();
        $anotherThread = Thread::factory()->create();
        $firstChannel = Channel::first();

        $this->get("/threads/{$firstChannel->slug}")
            ->assertSee($thread->title)
            ->assertDontSee($anotherThread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_username()
    {
        $user = $this->create(User::class);

        $threadByUser = $this->create(Thread::class, ['author_id' => $user->id]);
        $threadNotByUser = $this->create(Thread::class);

        $this->get("/threads?by={$user->name}")
            ->assertSee($threadByUser->body)
            ->assertDontSee($threadNotByUser->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        // $this->withoutExceptionHandling();
        $threadWithZeroReplies = $this->create(Thread::class);

        $threadWithTowReplies = $this->create(Thread::class);
        $this->create(Reply::class, ['thread_id' => $threadWithTowReplies->id], 2);

        $threadWithThreeReplies = $this->create(Thread::class);
        $this->create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
