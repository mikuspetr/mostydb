<?php

namespace App\Http\Controllers;

use App\Models\Address\Municipality;
use App\Models\Address\OrpRegion;
use Illuminate\Http\Request;
use \App\Models\Client;
use App\Models\ClientDescription;
use Illuminate\Contracts\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(50);
        return View('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = OrpRegion::whereIn('id', OrpRegion::ACTIVE_ORP_IDS)->get();
        $municipalities = Municipality::where('orp_region_id', OrpRegion::VSETIN_ORP_ID)->get();
        //dd($municipalities);
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
        //dd($request->all());
        $client = new Client();
        $client->pair_id = $request->client_status == 2 ? 'ZAJ' : Client::getNextPairId();
        $client->code = $request->code;
        $client->sex_id = $request->sex_id;
        $client->type_id = $request->type_id;
        $client->municipality_id = $request->municipality_id;
        $client->contract = $request->contract;
        $client->save();

        $clientDescription = new ClientDescription();
        $clientDescription->client_id = $client->id;
        $clientDescription->first_contact = $request->first_contact;
        $clientDescription->personal = $request->personal;
        $clientDescription->social = $request->social;
        $clientDescription->save();

        return redirect()->route('clients.show', [$client->id])->with(['message' => 'Nový klient <strong>'.$client->clientCode.'</strong> byl vytvořen.', 'status' => 'success']);
        //$clients = Client::paginate(50);
        //return View('clients.index', compact('clients'));
        //dd($client);
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
        $clients = Client::all();
        $records = \App\Models\Record::whereHas('clients', function($query) use($id){
            $query->where('client_id', $id);
        })->get();
        $IPs = \App\Models\IndividualPlan::where('client_id', $id)->get();
        //dd($records);
        return View('clients.show', compact('client', 'clients', 'records', 'IPs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client  = Client::find($id);
        //dd($client);
        $clients = Client::all();
        return View('clients.edit', compact('client', 'clients'));
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
        //
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
}
