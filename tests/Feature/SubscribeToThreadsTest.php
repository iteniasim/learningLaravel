<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanSubscribeToThreads()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscription');

        $this->assertCount(1, $thread->subscriptions);
    }

    public function testAUserCanUnsubscribeFromThreads()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(1, $thread->subscriptions);

        $this->delete($thread->path() . '/subscription');

        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
