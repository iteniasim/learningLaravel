<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/{$this->owner->username}/notices";

        // return route('notice.index', auth()->user());
        // apparently route helper function cannot be used to calculate the path in the notifications and mails if they are queued
        // so either just send mail or notification directly without queue or define the path explicitly yourself.
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }
}
