<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/imports/obce-orp-county2.csv"), "r");

        //$firstline = true;
        $municipalities = [];
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            //if (!$firstline) {
                \App\Models\Address\Municipality::create([
                    'name' => $data['1'],
                    'code' => $data['0'],
                    'orp_region_id' => $data['2'],
                    'county_id' => $data['4']
                ]);
            //}
            //$firstline = false;
        }
        fclose($csvFile);

        $csvFile = fopen(base_path("database/imports/orp.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {

                \App\Models\Address\OrpRegion::create([
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'municipalities' => $data['2']
                ]);
        }
        fclose($csvFile);

        $csvFile = fopen(base_path("database/imports/county2.csv"), "r");
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {

                \App\Models\Address\County::create([
                    'id' => $data['1'],
                    'name' => $data['3'],
                    'code' => $data['2'],
                    'code_nuts4' => $data['0']
                ]);
        }
        fclose($csvFile);
    }
}
