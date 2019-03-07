<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavouritesTest extends TestCase
{

    use RefreshDatabase;

    public function testGuestsCannotFavouriteAnything()
    {
        $this->post('/replies/1/favourites')
            ->assertRedirect('login');
    }

    public function testAnAuthenticatedUserCanFavouriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('/replies/' . $reply->id . '/favourites');

        $this->assertCount(1, $reply->favourites);
    }

    public function testAnAuthenticatedUserCanFavouriteAReplyOnlyOnce()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('/replies/' . $reply->id . '/favourites');
            $this->post('/replies/' . $reply->id . '/favourites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }

        $this->assertCount(1, $reply->favourites);
    }
}
