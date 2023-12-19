<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => \App\Models\Categories\Clients\Sex::MALE,
                'name' => 'Muž',
                'type' => \App\Models\Categories\Clients\Sex::class
            ],
            [
                'id' => \App\Models\Categories\Clients\Sex::FEMALE,
                'name' => 'Žena',
                'type' => \App\Models\Categories\Clients\Sex::class
            ],
            [
                'id' => \App\Models\Categories\Clients\Type::NEUROTIC,
                'name' => 'Neurotici',
                'type' => \App\Models\Categories\Clients\Type::class
            ],
            [
                'id' => \App\Models\Categories\Clients\Type::ADDICTED,
                'name' => 'Závislí',
                'type' => \App\Models\Categories\Clients\Type::class
            ],
        ]);
    }
}
