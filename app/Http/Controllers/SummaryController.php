<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\RecordPlace;

class SummaryController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        for($month = 1; $month <= 12; $month++) {
            $from = \Carbon\Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');
            $to = \Carbon\Carbon::create($year, $month)->endOfMonth()->format('Y-m-d');
            $records = Record::where('date', '>', $from)->where('date', '<', $to)->where('intervention', 1)->get();
            $row = [
                'name' => __(\Carbon\Carbon::create($year, $month)->format('F')),
                'from' => $from,
                'to' => $to,
                'records' => $records->count(),
                'duration' => round($records->sum('duration')/60),
                'plan' => 59,
            ];
            $months[] = $row;
        }

        $from = \Carbon\Carbon::create($year, 1)->startOfYear()->format('Y-m-d');
        $to = \Carbon\Carbon::create($year, 12)->endOfYear()->format('Y-m-d');

        $allPlaces = $this->getOverview($from, $to);
        $vsetin = $this->getOverview($from, $to, [RecordPlace::VSETIN]);
        $valmez = $this->getOverview($from, $to, [RecordPlace::VALMEZ]);

        $meetings = [
            'to-30' => [
                'name' => 'Počet setkánído 30 minut',
                'count' => Record::fromTo($from, $to)->where('duration', '<=', 30)->count(),
                'unique' => '',
            ],
            'to-60' => [
                'name' => 'Počet setkánído 60 minut',
                'count' => Record::fromTo($from, $to)->where('duration', '<=', 60)->count(),
                'unique' => Record::fromTo($from, $to)->where('duration', '>', 30)->where('duration', '<=', 60)->count(),
            ],
            'to-90' => [
                'name' => 'Počet setkánído 90 minut',
                'count' => Record::fromTo($from, $to)->where('duration', '<=', 90)->count(),
                'unique' => Record::fromTo($from, $to)->where('duration', '>', 60)->where('duration', '<=', 90)->count(),
            ],
            'to-120' => [
                'name' => 'Počet setkánído 120 minut',
                'count' => Record::fromTo($from, $to)->where('duration', '<=', 120)->count(),
                'unique' => Record::fromTo($from, $to)->where('duration', '>', 90)->where('duration', '<=', 120)->count(),
            ],
            'over-120' => [
                'name' => 'Počet setkání nad 120 minut',
                'count' => '',
                'unique' => Record::fromTo($from, $to)->where('duration', '>', 120)->count(),
            ],
        ];

        return view('summary.index', compact('year', 'months', 'allPlaces', 'vsetin', 'valmez', 'meetings'));
    }

    public function clients(Request $request)
    {
        $clients = \App\Models\Client::with('municipality')->where('pair_id', '!=', 'ZAJ')->whereHas('records',function($query) use($request){
            return $query->where('date', '>', $request->from)->where('date', '<', $request->to)->where('intervention', 1);
        })->orderByDesc('municipality_id')->get();

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

        return view('summary.clients', compact('municipalities', 'orps', 'noMunClients', 'request'));
    }

    private function getOverview($from, $to, $places = RecordPlace::ALL_PLACES)
    {
        $overview = [
            'contacts' => [
                'name' => 'Kontakty',
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->count(),
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->neurotics()->count(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->adicts()->count(),
            ],
            'individuals' => [
                'name' => 'Individuální intervence',
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->individualInterventions()->neurotics()->count(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->individualInterventions()->adicts()->count(),
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->individualInterventions()->count(),
            ],
            'interdiciplinars' => [
                'name' => 'Interdisciplinární intervence',
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->interdiciplinarInterventions()->neurotics()->count(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->interdiciplinarInterventions()->adicts()->count(),
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->interdiciplinarInterventions()->count(),
            ],
            'individuals-duration' => [
                'name' => 'Individuální intervence - čas',
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->individualInterventions()->neurotics()->duration(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->individualInterventions()->adicts()->duration(),
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->individualInterventions()->duration(),
            ],
            'interdiciplinars-duration' => [
                'name' => 'Interdisciplinární intervence - čas',
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->interdiciplinarInterventions()->neurotics()->duration(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->interdiciplinarInterventions()->adicts()->duration(),
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->interdiciplinarInterventions()->duration(),
            ],
            'contacts-pp' => [
                'name' => 'Přímá práce - čas',
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->durationPP(),
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->neurotics()->durationPP(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->adicts()->durationPP(),
            ],
            'groups' => [
                'name' => 'Skupinové intervence',
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->groupInterventions()->neurotics()->count(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->groupInterventions()->adicts()->count(),
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->groupInterventions()->count(),
            ],
            'groups-duration' => [
                'name' => 'Skupinové intervence - čas',
                'neurotics' => Record::whereIn('place_id', $places)->fromTo($from, $to)->groupInterventions()->neurotics()->duration(),
                'adicts' => Record::whereIn('place_id', $places)->fromTo($from, $to)->groupInterventions()->adicts()->duration(),
                'count' => Record::whereIn('place_id', $places)->fromTo($from, $to)->groupInterventions()->duration(),
            ],
        ];

        return $overview;
    }
}
