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
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    public function testAReplyRequiresABody()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    public function testAnUnauthenticatedUsersCannotDeleteReplies()
    {
        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function testAnAuthenticatedUsersCanDeleteReplies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->assertEquals(1, $reply->thread->replies_count);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function testAnUnauthenticatedUsersCannotUpdateReplies()
    {
        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function testAuthorizedUsersMayUpdateReplies()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $reply        = create('App\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'You have been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    public function testAReplyThatContainsSpamCannotBeCreated()
    {
        $this->signIn()->withExceptionHandling();
        $thread = create('App\Thread');
        $reply  = make('App\Reply', [
            'body' => 'spammmmmmmm',
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    public function testAReplyThatContainsSpamCannotBeUpdated()
    {
        $this->signIn()->withExceptionHandling();
        $thread = create('App\Thread');
        $reply  = create('App\Reply', ['user_id' => auth()->id()]);

        $this->patch("/replies/{$reply->id}", [
            'user_id' => auth()->id(),
            'body'    => 'spammmmmm',
        ])->assertStatus(422);
    }

}
