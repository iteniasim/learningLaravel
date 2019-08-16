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
        $this->withoutExceptionHandling();
        //we have a admin user then
        $this->signIn($admin = factory('App\User')->states('administrator')->create());

        //Given we have a channel
        $channel = create("App\Channel");

        //and users in that channel
        $mary = create("App\User", ['channel_id' => $channel->id, 'user_type' => 0]);
        $jane = create("App\User", ['channel_id' => $channel->id, 'user_type' => 0]);

        //and a user not in that channel
        $peter = create("App\User");

        $users = User::where('channel_id', $channel->id)->get();

        $this->assertCount(2, $users);

        //when new notices are posted for that channel
        $notice = make("App\Notice", ['channel_id' => $channel->id, 'recipient_type' => 0]);

        // dd(auth()->user()->username);

        $this->post(auth()->user()->username . '/notices', $notice->toArray());

        //all users with that channelid will get a notification about that notice

        $this->assertCount(1, $mary->notifications);
        $this->assertCount(1, $jane->notifications);
        $this->assertCount(0, $peter->notifications);

    }
}
