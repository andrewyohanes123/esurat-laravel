<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Opis\Closure\serialize;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'Direktur',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Wakil Direktur 1',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Wakil Direktur 2',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Wakil Direktur 3',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Kepala Bagian Umum',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Kepala Sub Bagian Umum',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Sekretaris Pimpinan',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Jurusan',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Unit',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Administrasi',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => true,
                    'forward.out' => true,
                ])
            ],
            [
                'name' => 'Administrator',
                'permissions' => serialize([
                    'view' => true,
                    'edit' => false,
                    'forward.in' => false,
                    'forward.out' => false,
                ])
                // 'permissions' => []
            ],
        ]);
    }
}
