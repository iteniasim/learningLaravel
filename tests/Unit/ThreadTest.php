<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    public function testAThreadCanReturnItsPath()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    public function testAThreadHasACreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    public function testAThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function testAThreadCanAddReply()
    {
        $this->thread->addReply([
            'body'    => 'foobar',
            'user_id' => 1,
        ]);
        $this->assertCount(1, $this->thread->replies);
    }

    public function testAThreadNotifiesItsSubscribersWhenNewRepliesAreAdded()
    {
        Notification::fake();

        $this->signIn()->thread->subscribe()->addReply([
            'body'    => 'foobar',
            'user_id' => 1,
        ]);

        Notification::assertSentTo(auth()->User(), ThreadWasUpdated::class);
    }

    public function testAThreadBelongsToAChannel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function testAThreadCanBeSubscribedTo()
    {
        // $this->signIn();
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where(['user_id' => $userId])->count()
        );
    }

    public function testAThreadCanBeUnsubscribedFrom()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where(['user_id' => $userId])->count()
        );

        $thread->unsubscribe($userId = 1);

        $this->assertEquals(
            0,
            $thread->subscriptions()->where(['user_id' => $userId])->count()
        );
    }

    public function testAThreadKnowsIfTheAuthenticatedUserIsSubscirbedToTheThread()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
