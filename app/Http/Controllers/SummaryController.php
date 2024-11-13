<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function clients(Request $request)
    {

        $clients = \App\Models\Client::with('municipality')->where('pair_id', '!=', 'ZAJ')->whereHas('records',function($query) use($request){
            return $query->where('date', '>', $request->from)->where('date', '<', $request->to)->where('intervention', 1);
        })->orderByDesc('municipality_id')->get();
        //dump($clients);
        $municipalities = $clients->groupBy('municipality_id')->mapWithKeys(function($clients, $munId){
            $mun = \App\Models\Address\Municipality::find($munId);
            if($mun) {
                return [$mun->name => $clients->count()];
            }
            return ['NEZAŘAZENO' => $clients->count()];
        });

        $orps = $clients->groupBy('municipality.orp_region_id')->mapWithKeys(function($clients, $orpId){
            $orp = \App\Models\Address\OrpRegion::find($orpId);
            if($orp) {
                return [$orp->name => $clients->count()];
            }
            return ['NEZAŘAZENO' => $clients->count()];
        });

        $noMunClients = \App\Models\Client::where('pair_id', '!=', 'ZAJ')->whereNull('municipality_id')
        ->whereHas('records',function($query) use($request){
            return $query->where('date', '>', $request->from)->where('date', '<', $request->to)->where('intervention', 1);
        })->get();
        //dd($orps);


        return view('summary.clients', compact('municipalities', 'orps', 'noMunClients', 'request'));
    }
}
