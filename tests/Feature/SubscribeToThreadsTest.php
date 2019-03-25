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
        $this->withoutExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscribe');

        //every time a new reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply',
        ]);

        $this->assertCount(1, $thread->subscriptions);

        //some kind of notification should be sent to all the subscribed users
        // $this->assertCount(1,auth()->user()->notifications);

    }
}
