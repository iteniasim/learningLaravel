<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNoticePosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notice;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notice)
    {
        $this->notice = $notice;
    }
}
