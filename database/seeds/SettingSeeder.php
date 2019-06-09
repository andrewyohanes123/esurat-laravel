<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'users_allow_create_disposition' => serialize([6, 7, 3, 4, 5, 8]),
            'users_allow_create_outbox' => serialize([1,2,3,4]),
            'director_send_to' => serialize([]),
            'co_director_send_to' => serialize([]),
            'other_user_send_to' => serialize([]),
            'administrator_send_to' => serialize([]),
        ]);
    }
}
