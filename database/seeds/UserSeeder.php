<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Department;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds for users (demo).
     *
     * @return void
     */
    public function run()
    {
        $depts = Department::all();
        foreach($depts as $i => $dept) :
            User::create([
                'name' => $dept->name,
                'email' => Str::slug(strtolower($dept->name), '.') . '@polimdo.ac.id',
                'password' => bcrypt('1234'),
                'role' => 'employee',
                'department_id' => $dept->id,
                'api_token' => Str::random(),
                'phone_number' => $i
            ]);
        endforeach;
    }
}
