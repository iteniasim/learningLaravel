<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadsController extends Controller
{
    public function update(Thread $thread)
    {
        $thread->lock();
    }
}
