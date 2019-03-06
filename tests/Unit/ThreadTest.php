<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }
    public function testAThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function testAThreadHasACreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    public function testAThreadCanAddReply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1,
        ]);
        $this->assertCount(1, $this->thread->replies);
    }
}
