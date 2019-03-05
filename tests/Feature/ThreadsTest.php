<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAUserCanBrowseThreads()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads')
            ->assertSee($thread->title);
    }

    public function testAUserCanReadASingleThread()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads/' . $thread->id)
            ->assertSee($thread->title);
    }
}
