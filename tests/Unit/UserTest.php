<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanFetchTheirMostRecentReply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', [
            'user_id' => $user->id,
        ]);
        $this->assertEquals($reply->id, $user->lastReply->id);
    }
}
