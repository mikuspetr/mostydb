<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Miriam Hurtova',
                'email' => 'miriam.hurtova@centrumarcha.cz',
                'login' => 'Miriam',
                'password' => bcrypt('TajneHeslo'),
            ],
            [
                'id' => 3,
                'name' => 'Ludmila Mácová',
                'email' => 'ludmila.macova@centrumarcha.cz',
                'login' => 'Lída',
                'password' => bcrypt('TajneHeslo'),
            ],
            [
                'id' => 4,
                'name' => 'Petr Mikuš',
                'email' => 'petr.mikus@centrumarcha.cz',
                'login' => 'mekke',
                'password' => bcrypt('TajneHeslo'),
            ],
            [
                'id' => 8,
                'name' => 'Miluše Fišerová',
                'email' => 'mila.fiserova@centrum.cz',
                'login' => 'Míla',
                'password' => bcrypt('TajneHeslo'),
            ]

        ];
        DB::table('users')->insert($users);
    }
}
