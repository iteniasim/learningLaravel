<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanSearchThreads()
    {
        config(['scout.driver' => 'algolia']);
        create('App\Thread', [], 2);
        create('App\Thread', ['body' => 'A thread with the foobar term.'], 2);
        do {
            // Account for latency.
            sleep(.25);
            $results = $this->getJson('/threads/search?q=foobar')->json()['data'];
        } while (empty($results));
        $this->assertCount(2, $results);
        // Clean up algolia index in the algolia server.
        Thread::latest()->take(4)->unsearchable();
    }
}
