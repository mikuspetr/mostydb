<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = \App\Models\Record::paginate(50);
        /*
        $records = \App\Models\Record::get()->filter(function($record){
            return $record->users->count() > 1;
        });
        */
        return View('records.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $places = \App\Models\RecordPlace::get()->map(function($place){
            return [$place->id => $place->name];
        })->flatten()->toArray();
        $clients = \App\Models\Client::get()->map(function($client){
            return [$client->id => $client->clientCode];
        })->flatten()->toArray();
        $users = \App\Models\User::get()->map(function($user){
            return [$user->id => $user->login];
        })->flatten()->toArray();
        return view('records.create', compact('places','clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = \App\Models\Record::find($id);
        return View('records.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = \App\Models\Record::find($id);
        return View('records.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
