<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->sentence(2);
    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
