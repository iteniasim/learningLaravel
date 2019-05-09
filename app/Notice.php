<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/' . auth()->user()->name . '/notices';
    }
}
