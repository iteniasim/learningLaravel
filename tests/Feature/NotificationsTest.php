<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function testANotificationIsPreparedWhenASubscribedThreadReceivesAReplyThatIsNotByTheCurrentUser()
    {
        $this->signIn();

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
        $this->signIn()->withoutExceptionHandling();
        $thread = create('App\Thread');
        $thread->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'some reply',
        ]);

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();
        $this->assertCount(1, $response);
    }

    public function testAUserCanMarkANotificationAsRead()
    {
        $this->signIn()->withoutExceptionHandling();
        $thread = create('App\Thread');
        $thread->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'some reply',
        ]);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
