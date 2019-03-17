<?php

namespace App\Http\Controllers;

use App\Reply;

class FavouritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favourite();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavourite();
    }
}
