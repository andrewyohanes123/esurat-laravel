<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\User;
use \App\Disposition;
use \App\DispositionMessage;
use \App\DispositionRelation;

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
        factory(\App\LetterFile::class, 90)->create();
        // DB::table('letter_files')->insert([
        //     ['name' => 'File 1', 'file' => '1.jpg'],
        //     ['name' => 'File 2', 'file' => '2.jpg'],
        //     ['name' => 'File 3', 'file' => '3.jpg']
        // ]);
        // DB::table('settings')->insert([
        //     'users_allow_create_disposition' => serialize([6, 7, 3, 4, 5, 8]),
        //     'users_allow_create_outbox' => serialize([1,2,3,4]),
        //     'director_send_to' => serialize([]),
        //     'co_director_send_to' => serialize([]),
        //     'other_user_send_to' => serialize([]),
        //     'administrator_send_to' => serialize([]),
        // ]);
        // $table->string('users_allow_create_disposition');
        //     $table->string('users_allow_create_outbox');
        //     $table->string('director_send_to');
        //     $table->string('co_director_send_to');
        //     $table->string('other_user_send_to');
        //     $table->string('administrator_send_to');
        // DB::table('departments')->insert([
        //     ['name' => 'Direktur'],
        //     ['name' => 'Wakil Direktur'],
        //     ['name' => 'Kepala Bagian Umum'],
        //     ['name' => 'Kepala Sub Bagian Umum'],
        //     ['name' => 'Sekretaris Pimpinan'],
        //     ['name' => 'Jurusan'],
        //     ['name' => 'Unit'],
        // ]);
        // DB::table('departments')->insert(['name' => 'Administrasi']);
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
