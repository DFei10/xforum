<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_threads()
    {
        $channel = Channel::factory()->create();

        Thread::factory()->create(['channel_id' => $channel->id]);

        $this->assertInstanceOf(Thread::class, $channel->threads->first());
    }
}
