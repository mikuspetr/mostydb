<?php

namespace App\Http\Controllers;

use App\Models\Address\Municipality;
use App\Models\Address\OrpRegion;
use Illuminate\Http\Request;
use \App\Models\Client;
use App\Models\ClientDescription;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = \App\Models\Client::query();
        if(Auth::user()->hasRole('auditor')) {
            $query->whereHas('records', function($q){
                $q->where('date', '>=', '2025-01-01'); // Auditors can only see clients with records from 2025
            });
        }
        if(isset($request->active_complaint) && $request->active_complaint == 1)
        {
            $clients = $query->withValidContract()->with('records')->get()->sortByDesc('lastRecordDate');;
        } else {
            $clients = $query->with('records')->get()->sortByDesc('lastRecordDate');
        }
        return View('clients.index', compact('clients', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = $this->getRegions();
        $municipalities = $this->getMunicipalities();
        return View('clients.create', compact('regions', 'municipalities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();
        $this->requestToClient($request, $client);

        $clientDescription = new ClientDescription();
        $clientDescription->client_id = $client->id;
        $this->requestToDescription($request, $clientDescription);

        return redirect()->route('clients.show', [$client->id])->with(['message' => 'Nový klient <strong>'.$client->clientCode.'</strong> byl vytvořen.', 'status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client  = Client::find($id);
        $recordQuery = \App\Models\Record::query();
        $IPsQuery = \App\Models\IndividualPlan::query();
        if(Auth::user()->hasRole('auditor')) {
            $recordQuery->where('date', '>=', '2025-01-01'); // Auditors can only see records from 2025
            $IPsQuery->where('date', '>=', '2025-01-01'); // Auditors can only see IPs from 2025
        }
        $records = $recordQuery->whereHas('clients', function($q) use($id){
            $q->where('client_id', $id);
        })->orderByDesc('date')->get();

        $IPs = $IPsQuery->where('client_id', $id)->orderByDesc('date')->get();
        return View('clients.show', compact('client', 'records', 'IPs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        $regions = $this->getRegions();
        $regionId = isset($client->municipality_id) ? $client->municipality->orp_region_id : null;
        $municipalities = $this->getMunicipalities($regionId);
        return View('clients.edit', compact('client', 'regions', 'municipalities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $this->requestToClient($request, $client);
        $this->requestToDescription($request, $client->description);
        return redirect()->route('clients.show', [$id])->with(['message' => 'Změny u klienta <strong>'.$client->clientCode.'</strong> byly uloženy.', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getRegions(): Collection
    {
        return OrpRegion::whereIn('id', OrpRegion::ACTIVE_ORP_IDS)->get();
    }

    private function getMunicipalities($orpId = null): Collection
    {
        return Municipality::where('orp_region_id', $orpId)->get();
    }

    private function requestToClient(Request $request, Client $client)
    {
        $client->pair_id = $request->client_type == 2 ? 'ZAJ' : Client::getNextPairId();
        $client->code = $request->code;
        $client->sex_id = $request->sex_id;
        $client->category_id = $request->category_id;
        $client->municipality_id = $request->municipality_id;
        $client->contract = $request->contract;
        $client->save();
    }

    private function requestToDescription(Request $request, ClientDescription $clientDescription)
    {
        $clientDescription->first_contact = $request->first_contact;
        $clientDescription->personal = $request->personal;
        $clientDescription->social = $request->social;
        $clientDescription->save();
    }
}
