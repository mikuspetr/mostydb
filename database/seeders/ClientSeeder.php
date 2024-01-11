<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $klienti = DB::connection('mostyold')->table('klienti')->get()->map(function ($klient) {
            return [
                'id' => $klient->id > 0 ? $klient->id : ($klient->id == -10 ? Client::NEW_NEUROTIC_ID : Client::NEW_ADICTED_ID),
                'code' => $klient->kod,
                'sex_id' => $klient->pohlavi == 'M' ? Client::MALE_ID : Client::FEMALE_ID,
                'pair_id' => $klient->uzivatel,
                'category_id' => $klient->zarazeni == 'Z' ? Client::ADDICTED_ID : Client::NEUROTIC_ID,
                'contract' => $klient->smlouva == '0000-00-00' ? null : $klient->smlouva,
                'municipality_id' => $klient->municipality_id,
            ];
        })->toArray();
        DB::table('clients')->insert($klienti);

        $anamnezy = DB::connection('mostyold')->table('anamneza')->get()->map(function ($anamneza) {
            return [
                'client_id' => $anamneza->id,
                'first_contact' => $anamneza->kontakt,
                'personal' => $anamneza->osobni,
                'social' => $anamneza->rodinna
            ];
        })->toArray();
        DB::table('client_descriptions')->insert($anamnezy);

        DB::table('sexes')->insert([
            ['id' => Client::MALE_ID, 'name' => 'Muž'],
            ['id' => Client::FEMALE_ID, 'name' => 'Žena']
        ]);
        DB::table('client_categories')->insert([
            ['id' => Client::ADDICTED_ID, 'name' => 'Závislí'],
            ['id' => Client::NEUROTIC_ID, 'name' => 'Neurotici']
        ]);
    }
}
