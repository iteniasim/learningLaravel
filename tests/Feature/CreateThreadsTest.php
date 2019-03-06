<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsMayNotCreateThreads()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads', []);
    }

    public function testAnAuthenticatedUserCanCreateNewThreads()
    {
        $this->actingAs($user = factory('App\User')->create());

        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title);
    }
}
