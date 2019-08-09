<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThread extends TestCase
{
    use RefreshDatabase;

    public function testOnceLockedAThreadCannotReceiveNewReplies()
    {
        $this->signIn();

        $thread = create('App\Thread', ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body'    => 'Foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }

    public function testNonAdminCannotLockThreads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch(route('locked-threads.update', $thread))->assertStatus(403);

        $this->assertFalse(!!$thread->fresh()->locked);
    }

    public function testAdminCanLockThreads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch(route('locked-threads.update', $thread));

        $this->assertTrue($thread->fresh()->locked);
    }

    public function testAdminCanUnlockThreads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => true]);

        $this->patch(route('locked-threads.update', $thread));

        $this->assertFalse($thread->fresh()->locked);

    }
}
