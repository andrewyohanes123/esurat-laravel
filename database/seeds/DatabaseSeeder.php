<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\User;
use \App\Disposition;
use \App\DispositionMessage;
use \App\DispositionRelation;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // factory(Disposition::class, 30)->create();
        // factory(DispositionMessage::class, 30)->create();
        // factory(\App\LetterFile::class, 90)->create();
        // DB::table('letter_files')->insert([
        //     ['name' => 'File 1', 'file' => '1.jpg'],
        //     ['name' => 'File 2', 'file' => '2.jpg'],
        //     ['name' => 'File 3', 'file' => '3.jpg']
        // ]);
        $this->call(DepartmentSeeder::class);
        $this->call(SettingSeeder::class);
        // $this->call(LetterTypesSeeder::class);
        // $ids = User::all()->pluck('id')->toArray();
        // foreach($ids as $id):
        //     User::whereId($id)->update(['api_token' => Str::random(60)]);
        // endforeach;
        // \App\LetterType::insert([
        //     ['name' => 'Penting'],
        //     ['name' => 'Sangat Penting'],
        // ]);
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@a.com',
            'password' => bcrypt('1234'),
            'department_id' => 11,
            'role' => 'administrator'
        ]);
        $this->call(UserSeeder::class);
    }
}
