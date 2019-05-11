<?php

use Faker\Generator as Faker;

$factory->define(App\Notice::class, function (Faker $faker) {
    return [
        //
        'user_id'        => function () {
            return factory("App\User")->create()->id;
        },
        'channel_id'     => function () {
            return factory("App\Channel")->create()->id;
        },
        'recipient_type' => $faker->boolean(),
        'title'          => $faker->sentence,
        'body'           => $faker->paragraph,

    ];
});
