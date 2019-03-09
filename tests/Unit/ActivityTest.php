<?php

namespace Tests\Unit;

use App\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function testItRecordsActivityWhenAThreadIsCreated()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function testItRecordsActivityWhenAReplyIsCreated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }
}
