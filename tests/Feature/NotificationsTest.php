<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    public function testANotificationIsPreparedWhenASubscribedThreadReceivesAReplyThatIsNotByTheCurrentUser()
    {
        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'some reply',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'some reply',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function testAUserCanFetchTheirUnreadNotificaitons()
    {
        create(DatabaseNotification::class);

        $response = $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json();
        $this->assertCount(1, $response);
    }

    public function testAUserCanMarkANotificationAsRead()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    public function testMentionedUsersInAReplyAreNotified()
    {
        $john = create('App\User', [
            'name' => 'johndoe',
        ]);
        $this->signIn($john);

        $reply = make('App\Reply', [
            'body' => '@johndoe is mentioned.',
        ]);

        $this->post($reply->thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $john->notifications);
    }
}
