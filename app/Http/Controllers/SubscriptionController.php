<?php

namespace App\Http\Controllers;

use App\Thread;

class SubscriptionController extends Controller
{

    public function store($channel, Thread $thread)
    {
        $thread->subscribe();
    }

    public function destroy(Thread $thread)
    {
        $thread->unsubscribe();
    }
}
