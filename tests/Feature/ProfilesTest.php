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

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    public function testProfilesDisplayAllThreadsCreatedByTheAssociatedUser()
    {
        $this->withoutExceptionHandling();

        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
