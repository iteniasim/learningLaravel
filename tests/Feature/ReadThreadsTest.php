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
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadASingleThread()
    {
        $response = $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        $response = $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }
}
