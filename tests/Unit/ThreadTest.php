<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_a_path()
    {
        $thread = Thread::factory()->create();

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    public function it_has_a_replies()
    {
        $thread = Thread::factory()->create();
        Reply::factory()->create(['thread_id' => $thread->id]);

        $this->assertInstanceOf(Collection::class, $thread->replies);
        $this->assertInstanceOf(Reply::class, $thread->replies->first());
    }

    /** @test */
    public function it_has_an_author()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf(User::class, $thread->author);
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $thread = Thread::factory()->create();

        $thread->addReply([
            'body' => $this->faker->paragraph(),
            'owner_id' => User::factory()->create()->id
        ]);

        $this->assertCount(1, Reply::all());
    }

    /** @test */
    public function it_belongs_to_a_channel()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
