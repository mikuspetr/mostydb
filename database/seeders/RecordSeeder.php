<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $formy = DB::connection('mostyold')->table('forma')->get()->map(function ($forma) {
            return [
                'id' => $forma->id,
                'name' => $forma->forma
            ];
        })->toArray();
        DB::table('record_forms')->insert($formy);

        $places = DB::connection('mostyold')->table('misto')->get()->map(function ($place) {
            return [
                'id' => $place->id,
                'name' => $place->m
            ];
        })->toArray();
        DB::table('record_places')->insert($places);

        $kinds = DB::connection('mostyold')->table('typ1')->get()->map(function ($kind) {
            return [
                'id' => $kind->id,
                'name' => $kind->typ1
            ];
        })->toArray();
        DB::table('record_kinds')->insert($kinds);

        $types = DB::connection('mostyold')->table('typ2')->get()->map(function ($type) {
            return [
                'id' => $type->id,
                'name' => $type->typ2
            ];
        })->toArray();
        DB::table('record_types')->insert($types);

        $statuses = [
            [
                'id' => \App\Models\Status::GREEN,
                'name' => 'Zelená',
                'color' => 'limegreen',
            ],
            [
                'id' => \App\Models\Status::BLUE,
                'name' => 'Modrá',
                'color' => 'blue',
            ],
            [
                'id' => \App\Models\Status::RED,
                'name' => 'Červená',
                'color' => 'red',
            ],
        ];
        DB::table('statuses')->insert($statuses);

        $zaznamy = DB::connection('mostyold')->table('zaznamy')->get();//->chunk(50)->toArray();
        $skupiny = DB::connection('mostyold')->table('int_skupinova')->select(['zaznam', 'klient'])->where('klient', '>', 0)->get();
        $records = $clients = $users = [];
        //$recordId = 0;
        //foreach($zaznamyChunk as $zaznamy):
            $records = $clients = $users = [];

        foreach($zaznamy as $zaznam)
        {
            $status = null;
            if($zaznam->oznaceni == 'limegreen'){
                $status = \App\Models\Status::GREEN;
            }
            if($zaznam->oznaceni == 'blue'){
                $status = \App\Models\Status::BLUE;
            }
            if($zaznam->oznaceni == 'red'){
                $status = \App\Models\Status::RED;
            }
            array_push($records, [
                'id' => $zaznam->id,
                'date' => $zaznam->datum == '0000-00-00' ? null : $zaznam->datum,
                'place_id' => $zaznam->misto,
                'form_id' => $zaznam->forma,
                'kind_id' => $zaznam->Typ1,
                'type_id' => $zaznam->typ2,
                'duration' => $zaznam->cas,
                'duration_pp' => $zaznam->cas_pp,
                'text' => $zaznam->text,
                'status_id' => $status,
                'intervention' => $zaznam->intervence,
            ]);
            if($zaznam->klient > 0) {
                $kl = $zaznam->klient;
            }
            elseif($zaznam->klient == -10) {
                $kl = \App\Models\Client::NEW_NEUROTIC_ID;
            }
            elseif($zaznam->klient == -11) {
                $kl = \App\Models\Client::NEW_ADICTED_ID;
            }
            else {
                $kl = null;
            }
            if($kl !== null){
                $clients[] = ['record_id' => $zaznam->id, 'client_id' => $kl];
            }

            $moreClients = $skupiny->where('zaznam', $zaznam->id);
            if($moreClients->count() > 0)
            {
                $moreClients = $moreClients->map(function($m){
                    return [
                        'record_id' => $m->zaznam,
                        'client_id' => $m->klient
                    ];
                })->toArray();

                $clients = array_merge($clients, $moreClients);
            }
            $users[] = ['record_id' => $zaznam->id, 'user_id' => $zaznam->pracovnik];
            if($zaznam->pracovnik2 != 0)
            {
                $users[] = ['record_id' => $zaznam->id, 'user_id' => $zaznam->pracovnik2];
            }
        }
        DB::table('records')->insert($records);
        DB::table('record_clients')->insert($clients);
        DB::table('record_users')->insert($users);
        //endforeach;

    }
}
