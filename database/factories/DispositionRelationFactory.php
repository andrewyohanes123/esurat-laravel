<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\DispositionRelation;
use Faker\Generator as Faker;

$factory->define(DispositionRelation::class, function (Faker $faker) {
    $users = \App\User::all()->pluck('id')->toArray();
    $d = \App\Disposition::all()->pluck('id')->toArray();
    $dm = \App\DispositionMessage::all()->pluck('id')->toArray();
    return [
        'from_user' => $faker->randomElement($users),
        'to_user' => $faker->randomElement($users),
        'disposition_id' => $faker->randomElement($d),
        'disposition_message_id' => $faker->randomElement($dm),
    ];
});
