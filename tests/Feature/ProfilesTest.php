<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;
    public function testAUserHasAProfile()
    {
        $this->withoutExceptionHandling();

        $user = create('App\User');

        $this->get("/profiles/{$user->username}")
            ->assertSee($user->name);
    }

    public function testProfilesDisplayAllThreadsCreatedByTheAssociatedUser()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->username)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
