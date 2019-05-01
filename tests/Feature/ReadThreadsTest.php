<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function testAUserCanBrowseThreads()
    {
        $this->withoutExceptionHandling();
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadASingleThread()
    {
        $this->withoutExceptionHandling();
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $this->withoutExceptionHandling();
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function testAUserCanFilterThreadsAccordingToChannel()
    {
        $this->withoutExceptionHandling();
        $channel            = create('App\Channel');
        $threadInChannel    = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function testAUserCanFilterThreadsByAnyUsername()
    {
        $this->withoutExceptionHandling();
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn    = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function testAUserCanFilterThreadsByPopularity()
    {
        $threadWithNoReplies = $this->thread;

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $response = $this->getJson('threads?popular=1')->json();

        // dd($response);

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    public function testAUserCanFilterThreadsByUnansweredThreads()
    {
        $threadWithNoReplies = $this->thread;
        $threadWithReplies   = create('App\Thread');
        $reply               = create('App\Reply', ['thread_id' => $threadWithReplies->id]);

        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response['data']);
    }

    public function testAUserCanGetAllRepliesForAGivenThread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 20);
        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertCount(10, $response['data']);
        $this->assertEquals(20, $response['total']);
    }
}
