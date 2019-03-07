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
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadASingleThread()
    {
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function testAUserCanFilterThreadsAccordingToChannel()
    {
        $this->withoutExceptionHandling();
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function testAUserCanFilterThreadsByAnyUsername()
    {
        $this->withoutExceptionHandling();
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }
}
