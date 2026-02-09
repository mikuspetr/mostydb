<?php

namespace App\Http\Controllers;

use App\Models\IndividualPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndividualPlanController extends Controller
{
    public function index(Request $request)
    {
        // Get filter variables from request
        $clientId = $request->input('client_id');
        $userId = $request->input('user_id');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Get sorting variables from request
        $sortBy = $request->input('sort', 'date');
        $sortDir = $request->input('direction', 'desc');

        // Build the query
        $query = IndividualPlan::query();

        // Filters
        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        if ($dateFrom) {
            if(Auth::user()->hasRole('auditor') && $dateFrom < '2025-01-01') {
                $dateFrom = '2025-01-01'; // Auditors can only see records from 2025
            }
            $query->whereDate('date', '>=', $dateFrom);

        } elseif (Auth::user()->hasRole('auditor')) {
            $query->where('date', '>=', '2025-01-01'); // Auditors can only see records from 2025
        }

        if ($dateTo) {
            $query->whereDate('date', '<=', $dateTo);
        }

        // Sorting
        $query->orderBy($sortBy, $sortDir);

        // Get the plans
        $plans = $query->paginate(50);

        return view('individual-plans.index', [
            'plans' => $plans,
            'clients' => \App\Models\Client::all(),
            'users' => \App\Models\User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = \App\Models\Client::all();

        return view('individual-plans.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'nullable|date',
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
        ]);

        IndividualPlan::create([
            'client_id' => $request->client_id,
            'date' => $request->date,
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return redirect()->route('individual-plans.index')
            ->with('success', 'Individuální plán byl úspěšně vytvořen.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = IndividualPlan::with('client')->findOrFail($id);

        return view('individual-plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = IndividualPlan::findOrFail($id);
        $clients = \App\Models\Client::all();

        return view('individual-plans.edit', compact('plan', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plan = IndividualPlan::findOrFail($id);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'nullable|date',
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
        ]);

        $plan->update([
            'client_id' => $request->client_id,
            'date' => $request->date,
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return redirect()->route('individual-plans.index')
            ->with('success', 'Individuální plán byl úspěšně aktualizován.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = IndividualPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('individual-plans.index')
            ->with('success', 'Individuální plán byl úspěšně smazán.');
    }
}
