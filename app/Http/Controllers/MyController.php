<?php

namespace App\Http\Controllers;

use App\Http\Resources\MunicipalityResource;
use App\Models\Address\Municipality;
use App\Models\Address\OrpRegion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MyController extends Controller
{
    public function debug(Request $request)
    {
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
