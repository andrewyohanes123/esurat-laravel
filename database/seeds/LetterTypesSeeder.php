<?php

use Illuminate\Database\Seeder;
use App\LetterType;

class LetterTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LetterType::insert([
            ['name' => 'Penting'],
            ['name' => 'Sangat Penting'],
        ]);
    }
}
