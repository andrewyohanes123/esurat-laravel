<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 30)->create();
        // DB::table('departments')->insert(['name' => 'Administrasi']);
        // DB::table('departments')->insert([
        //     ['name' => 'Direktur'],
        //     ['name' => 'Wakil Direktur'],
        //     ['name' => 'Kepala Bagian Umum'],
        //     ['name' => 'Kepala Sub Bagian Umum'],
        //     ['name' => 'Sekretaris Pimpinan'],
        //     ['name' => 'Jurusan'],
        //     ['name' => 'Unit'],
        // ]);
        // User::create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@a.com',
        //     'password' => bcrypt('1234'),
        //     'department_id' => 1,
        //     'role' => 'administrator'
        // ]);
        // $this->call(UsersTableSeeder::class);
    }
}
