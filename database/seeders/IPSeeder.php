<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $IPs = DB::connection('mostyold')->table('ip')->where('klient', '>', 0)->get()->map(function ($ip) {
            return [
                'client_id' => $ip->klient,
                'date' => $ip->datum == '0000-00-00' ? null : $ip->datum,
                'title' => $ip->nadpis,
                'text' => $ip->text
            ];
        })->toArray();
        DB::table('individual_plans')->insert($IPs);
    }
}
