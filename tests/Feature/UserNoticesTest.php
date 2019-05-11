<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNoticesTest extends TestCase
{
    use RefreshDatabase;

    public function testRelevantUsersOfTheNoticeGetNotified()
    {
        //we have a user then
        $this->signIn()->withoutExceptionHandling();

        //Given we have a channel
        $channel = create("App\Channel");

        //and users in that channel
        $john  = create("App\User", ['channel_id' => $channel->id]);
        $jane  = create("App\User", ['channel_id' => $channel->id]);
        $henry = create("App\User");

        $users = User::where('channel_id', $channel->id)->get();

        $this->assertCount(2, $users);

        //when new notices are posted for that channel
        $notice = make("App\Notice", ['channel_id' => $channel->id]);

        $this->post(auth()->user()->name . '/notices', $notice->toArray());

        //all users with that channelid will get a notification about that notice

        $this->assertCount(1, $john->notifications);
        $this->assertCount(1, $jane->notifications);
        $this->assertCount(0, $henry->notifications);

    }
}
