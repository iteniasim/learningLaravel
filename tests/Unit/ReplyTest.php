<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function testItHasAOwner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    public function testItKnowsIfItWasJustPublished()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subHour();

        $this->assertFalse($reply->wasJustPublished());
    }

    public function testItCanDetectAllMentionedUsersInTheBody()
    {
        $reply = make('App\Reply', [
            'body' => '@JohnDoe and @JaneDoe',
        ]);

        $this->assertEquals(['JohnDoe', 'JaneDoe'], $reply->mentionedUsers());
    }

    public function testWrapsMentionedUserNamesInTheBodyWithinAnchorTags()
    {
        $reply = make('App\Reply', [
            'body' => 'Hello @JaneDoe',
        ]);

        $this->assertEquals('Hello <a href="/profiles/JaneDoe">@JaneDoe</a>', $reply->body);
    }

    public function testItKnowsIfItIsTheBestReply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    public function testAReplyKnowsIfItsCreatorIsTheThreadOwner()
    {
        $this->signIn(create('App\User', ['id' => 5]));

        $thread = create('App\Thread', ['user_id' => 5]);

        $ownerReply = create('App\Reply', ['user_id' => 5, 'thread_id' => $thread->id]);

        $otherReply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->assertEquals('own', $ownerReply->replyOwnerThreadRelationship());
        $this->assertEquals('subscribed', $otherReply->replyOwnerThreadRelationship());

    }
}
