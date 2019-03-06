<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function testAnUnauthenticatedUserMayNotAddReplies()
    {
        $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory('App\Thread')->create();

        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    public function testAnAuthenticatedUserMayParticipateInForumThread()
    {
        $this->withoutExceptionHandling();
        $this->be($user = create('App\User'));

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}
