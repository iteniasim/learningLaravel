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

        $this->post($thread->path() . '/subscribe');

        //every time a new reply is left
        // $thread->addReply([
        //     'user_id' => auth()->id(),
        //     'body' => 'some reply',
        // ]);

        $this->assertCount(1, $thread->subscriptions);

        //some kind of notification should be sent to all the subscribed users
        // $this->assertCount(1,auth()->user()->notifications);

    }

    public function testAUserCanUnsubscribeFromThreads()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(1, $thread->subscriptions);

        $this->delete($thread->path() . '/subscribe');

        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
