<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourites extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function favourited()
    {
        return $this->morphTo();
    }
}
