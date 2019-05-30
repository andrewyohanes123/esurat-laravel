<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Disposition;
use Faker\Generator as Faker;
use App\LetterType;

$factory->define(Disposition::class, function (Faker $faker) {
    $types = LetterType::all('id')->pluck('id')->toArray();
    return [
        'purpose' => $faker->text(5),
        'content' => $faker->text(15),
        'description' => $faker->paragraph(1),
        'reference_number' => $faker->text(8),
        'letter_type_id' => $faker->randomElement($types)
    ];
});
