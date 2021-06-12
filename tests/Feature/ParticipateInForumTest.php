<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->post('threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = Thread::factory()->create();
        $replyAttributes = Reply::factory()->make(['thread_id' => $thread->id]);

        $this->post("{$thread->path()}/replies", $replyAttributes->toArray());

        $this->get($thread->path())
            ->assertSee($replyAttributes->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = Thread::factory()->create();

        $this->post("{$thread->path()}/replies", Reply::factory()->raw(['body' => null]))
            ->assertSessionHasErrors('body');
    }
}
