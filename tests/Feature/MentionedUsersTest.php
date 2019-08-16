<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionedUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testMentionedUsersInAReplyAreNotified()
    {
        $this->withoutExceptionHandling();
        $john = create('App\User', ['username' => 'john_doe']);
        $this->signIn($john);

        $this->assertCount(0, $john->notifications);

        $reply = make('App\Reply', [
            'body' => '@john_doe is mentioned.',
        ]);

        $this->post($reply->thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $john->fresh()->notifications);
    }
}
