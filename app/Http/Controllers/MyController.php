<?php

namespace App\Http\Controllers;

use App\Http\Resources\MunicipalityResource;
use App\Models\Address\Municipality;
use App\Models\Address\OrpRegion;
use App\Models\RecordClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class MyController extends Controller
{
    public function debug(Request $request)
    {
        if(!Auth::user()->hasRole('admin')) {
            return redirect()->route('home');
        }
        $clients = \App\Models\Client::whereHas('records',function($query){
            return $query->where('date', '>', '2023-01-01')->where('date', '<', '2024-01-01');
        })->get();
        dd($clients);

        $record = \App\Models\Record::find(4709);

        $clientsColl = \App\Models\Client::limit(3)->get();
        dump($record->clients->pluck('id')->toArray(), $clientsColl->pluck('id')->toArray());
        dump(array_diff($record->clients->pluck('id')->toArray(), $record->clients->pluck('id')->toArray()));
        dump(array_diff($clientsColl->pluck('id')->toArray()), $record->clients->pluck('id')->toArray());
        dd(array_diff($record->clients->pluck('id')->toArray(), $clientsColl->pluck('id')->toArray()));
        $client = \App\Models\Client::find(5);

        $clientsArray = $clientsColl->map(function($client) use ($record){
                return [
                    'record_id' => $record->id,
                    'client_id' => $client->id
                ];
        })->filter(function($item) use($record){
            return !$record->hasClientId($item['client_id']);
        })->toArray();

        dd($clientsColl, $client, $clientsArray);
        dd($record->clients->where('id', $client->id)->count());
        dd($record->clients, $client);
        $r = RecordClient::first();
        dd($r);
        $records = \App\Models\Record::whereDoesntHave('clients')->get();
        dd($records);
        $client = \App\Models\Client::find(270);
        dd($client->description);
        $routeCurrent = Route::is('debug');
        dd($routeCurrent);
        //$role = Role::create(['name' => 'editor']);
        //$permission = Permission::create(['name' => 'edit users permisions']);

        //$role = Role::find(1);
        //$role->syncPermissions(Permission::get());
        //dd($role);

        $user = User::find(4);
        $user->assignRole('admin');
        dd($user->getRoleNames());

        $roles = Role::get();
        dd($roles);

        $record = \App\Models\Record::find(1);
        dd($record->clients);
        dd(\App\Models\Client::getNextPairId());
        $zaznamyChunk = DB::connection('mostyold')->table('zaznamy')->take(200)->get()->chunk(50)->toArray();

        dd($zaznamyChunk[1][50]->id);
        $clients = \App\Models\Client::get();
        //dd($clients);
        return view('debug', ['clients' => $clients]);
    }

    public function getMunicipalities($orpId)
    {
        return MunicipalityResource::collection(Municipality::where('orp_region_id', $orpId)->get());
    }
}
