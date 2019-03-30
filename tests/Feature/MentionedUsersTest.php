<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionedUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testMentionedUsersInAReplyAreNotified()
    {
        $john = create('App\User', ['name' => 'johndoe']);
        $this->signIn($john);

        $reply = make('App\Reply', [
            'body' => '@johndoe is mentioned.',
        ]);

        $this->post($reply->thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $john->notifications);
    }
}
