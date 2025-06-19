<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter variables from request
        $clientId = $request->input('client_id');
        $userId = $request->input('user_id');
        $placeId = $request->input('place_id');
        $typeId = $request->input('type_id');
        $kindId = $request->input('kind_id');
        $colorId = $request->input('color_id');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Get sorting variables from request
        $sortBy = $request->input('sort', 'date');
        $sortDir = $request->input('direction', 'desc');

        $clients = \App\Models\Client::get();
        $users = \App\Models\User::get();
        $places = \App\Models\RecordPlace::get();
        $types = \App\Models\RecordType::get();
        $kinds = \App\Models\RecordKind::get();
        $recordColors = \App\Models\RecordColor::get();

        $query = \App\Models\Record::query();

        // Filters
        if ($clientId) {
            $query->whereHas('clients', function ($q) use ($clientId) {
                $q->where('clients.id', $clientId);
            });
        }
        if ($userId) {
            $query->whereHas('users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            });
        }
        if ($placeId) {
            $query->where('place_id', $placeId);
        }
        if ($typeId) {
            $query->where('type_id', $typeId);
        }
        if ($kindId) {
            $query->where('kind_id', $kindId);
        }
        if( $colorId) {
            $query->where('color_id', $colorId);
        }
        if ($dateFrom) {
            $query->where('date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('date', '<=', $dateTo);
        }

        // Only allow sorting by certain columns for security
        $allowedSorts = ['date', 'duration', 'id'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'date';
        }

        $records = $query->orderBy($sortBy, $sortDir)->paginate(50)->appends($request->all());

        return view('records.index', compact(
            'records', 'clientId', 'userId', 'placeId', 'typeId', 'kindId', 'colorId', 'dateFrom', 'dateTo', 'sortBy', 'sortDir',
            'clients', 'users', 'places', 'types', 'kinds', 'recordColors'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = \App\Models\Client::get();
        $users = \App\Models\User::withoutAdminRole()->get();
        $places = \App\Models\RecordPlace::get();
        $recordForms = \App\Models\RecordForm::get();
        $recordTypes = \App\Models\RecordType::get();
        $recordColors = \App\Models\RecordColor::get();
        $individualDurations = $this->getIndividualDurations();
        $kontaktDurations = $this->getKontaktDurations();
        $groupDurations = $this->getGroupDurations();
        return view('records.create', compact('places', 'clients', 'users', 'recordForms', 'recordTypes', 'recordColors', 'individualDurations', 'groupDurations', 'kontaktDurations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $record = new Record();
        $this->requestToRecord($request, $record);
        $this->saveRecordClients($request, $record);
        $this->saveRecordUsers($request, $record);
        $record->refresh();
        return redirect('records');
        return View('records.show', compact('record'));
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
        $clients = \App\Models\Client::get();
        $users = \App\Models\User::withoutAdminRole()->get();
        $places = \App\Models\RecordPlace::get();
        $recordForms = \App\Models\RecordForm::get();
        $recordTypes = \App\Models\RecordType::get();
        $recordColors = \App\Models\RecordColor::get();
        $individualDurations = $this->getIndividualDurations();
        $kontaktDurations = $this->getKontaktDurations();
        $groupDurations = $this->getGroupDurations();
        return View('records.edit', compact('record', 'places', 'clients', 'users', 'recordForms', 'recordTypes', 'recordColors', 'individualDurations', 'groupDurations', 'kontaktDurations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all(), $id);
        $record = Record::find($id);
        $this->requestToRecord($request, $record);
        if(!empty(array_diff($record->clients->pluck('id')->toArray(), $request->clients))) {
            $this->saveRecordClients($request, $record);
        }
        if(!empty(array_diff($record->users->pluck('id')->toArray(), $request->users))) {
            $this->saveRecordUsers($request, $record);
        }
        return redirect('records');
        return View('records.show', compact('record'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $record = Record::find($id);
        if ($record) {
            $record->recordClients->map->delete();
            $record->recordUsers->map->delete();
            $record->delete();
        }
        return redirect('records')->with('info', 'Záznam #' . $record->id . ' byl úspěšně smazán.');
    }

    private function requestToRecord(Request $request, Record $record)
    {
        $record->date = $request->date;
        $record->place_id = $request->place_id;
        $record->duration = $request->duration;
        $record->duration_pp = $request->duration_pp;
        $record->form_id = $request->form_id;
        $record->type_id = $request->type_id;
        $record->color_id = $request->color_id;
        $record->intervention = $request->intervention;
        $record->kind_id = $request->kind_id;
        $record->text = $request->text;
        $record->save();
    }

    private function saveRecordClients(Request $request, Record $record)
    {
        $clients = Client::whereIn('id', $request->clients)->get();
        $record->recordClients->map->delete();
        $record->addClients($clients);
    }

    private function saveRecordUsers(Request $request, Record $record)
    {
        $users = User::whereIn('id', $request->users)->get();
        $record->recordUsers->map->delete();
        $record->addUsers($users);
    }

    private function getGroupDurations(): array
    {
        return [
            30 => '30 min',
            45 => '45 min',
            60 => '1 h',
            90 => '1,5 h',
            120  => '2 h',
            150  => '2,5 h',
            180  => '3 h',
            210  => '3,5 h',
            240  => '4 h',
            300  => '5 h',
            360  => '6 h',
            420  => '7 h',
            480  => '8 h',
            540  => '9 h',
            600  => '10 h',
            660  => '11 h',
            720  => '12 h',
            780  => '13 h',
        ];
    }

    private function getIndividualDurations(): array
    {
        return [
            30 => '30 min',
            45 => '45 min',
            60 => '1 h',
            90 => '1,5 h',
            120  => '2 h',
            150  => '2,5 h',
            180  => '3 h',
            210  => '3,5 h',
            240  => '4 h',
        ];
    }

    private function getKontaktDurations(): array
    {
        return [
            1 => '1 min',
            2 => '2 min',
            2 => '2 min',
            4 => '4 min',
            5 => '5 min',
            6 => '6 min',
            7 => '7 min',
            8 => '8 min',
            9 => '9 min',
            10 => '10 min',
        ];
    }

}
