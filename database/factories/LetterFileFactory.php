<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\LetterFile;
use Faker\Generator as Faker;

$factory->define(LetterFile::class, function (Faker $faker) {
    $name = ['file 1', 'file 2', 'file 3'];
    $file = ['1.jpg', '2.jpg', '3.jpg'];
    $d = \App\Disposition::all()->pluck('id')->toArray();
    return [
        'name' => $faker->randomElement($name),
        'file' => $faker->randomElement($file),
        'disposition_id' => $faker->randomElement($d)
    ];
});
