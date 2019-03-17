<?php

namespace App;

trait Favouritable
{
    public function favourites()
    {
        return $this->morphMany('App\Favourites', 'favourited');
    }

    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];

        if ((!$this->favourites()->where($attributes)->exists())) {
            $this->favourites()->create($attributes);
        }
    }

    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (($this->favourites()->where($attributes)->exists())) {
            $this->favourites()->where($attributes)->delete();
        }
    }

    public function isFavourited()
    {
        return !!$this->favourites->where('user_id', auth()->id())->count();
    }

    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}
