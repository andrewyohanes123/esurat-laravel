<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\DispositionMessage;
use Faker\Generator as Faker;

$factory->define(DispositionMessage::class, function (Faker $faker) {
    $users = \App\User::all()->pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($users),
        'message' => $faker->paragraph(3)
    ];
});
