<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->get('/threads/create')
        ->assertRedirect('/login');

        $this->post('/threads', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_threads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = Thread::factory()->make();

        $this->post('/threads', $thread->toArray());

        $this->get(Thread::first()->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $threads = $this->create(Thread::class);

        // When not Signed In, assert Redirect
        $this->delete($threads->path())
            ->assertRedirect('/login');

        // When not Authorized Assert Abort
        $this->signIn();

        $this->delete($threads->path())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = $this->create(Thread::class, ['author_id' => auth()->id()]);
        $reply = $this->create(Reply::class, ['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }

    // /** @test */
    // public function threads_may_only_be_deleted_by_those_who_have_permission()
    // {
    //     $this->delete('/threads/channel/1')
    //         ->assertStatus(403);
    // }

    protected function publishThread($overrides = [])
    {
        $this->signIn();

        return $this->post('/threads', Thread::factory()->raw($overrides));
    }
}
