<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadsController extends Controller
{
    public function update(Thread $thread)
    {
        if (!$thread->locked) {
            $thread->update(['locked' => true]);
        } else {
            $thread->update(['locked' => false]);
        }
    }
}
