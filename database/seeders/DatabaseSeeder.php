<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //dd(1);
        $this->call([
            //UserSeeder::class,
            //CategorySeeder::class,
            //ClientSeeder::class,
            //RecordSeeder::class,
            IPSeeder::class,
            //AddressSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    protected function insertChunk($tableName, $chunk)
    {
        foreach($chunk as $insertArray){
            DB::table($tableName)->insert($insertArray);
        }
    }
}
