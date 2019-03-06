<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestsMayNotCreateThreads()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanCreateNewThreads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title);
    }

    public function testAThreadRequiresATitle()
    {
        $this->publishThreads(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function testAThreadRequiresABody()
    {
        $this->publishThreads(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function testAThreadRequiresAValidChannel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThreads(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThreads(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThreads($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
