<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticatedUserMayNotAddReplies()
    {
        $thread = create('App\Thread');

        $this->post($thread->path() . '/replies', [])
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserMayParticipateInForumThread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    public function testAReplyRequiresABody()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
