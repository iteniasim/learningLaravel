<?php

namespace App\Listeners;

use App\Events\NewNoticePosted;
use App\Notifications\YouHaveANotice;

class NotifyRelatedUsers
{
    /**
     * Handle the event.
     *
     * @param  NewNoticePosted  $event
     * @return void
     */
    public function handle(NewNoticePosted $event)
    {
        User::where([
            ['channel_id', '=', $event->notice->channel_id],
            ['user_type', '=', $event->notice->recipient_type],
        ])
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouHaveANotice($event->notice));
            });
    }
}
