<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('roles.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = \Spatie\Permission\Models\Role::find($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = \Spatie\Permission\Models\Role::find($id);
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all(), $request->permissions);
        $role = \Spatie\Permission\Models\Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = \Spatie\Permission\Models\Role::find($id);
        if($role->users()->count() > 0)
        {
            return redirect()->route('roles.index')->with(['info' => 'Nelze smazat roli, která je přiřazena uživatelům.']);
        }
        $role->delete();
        return redirect()->route('roles.index')->with('info', 'Role ' . $role->name . ' byla úspěšně smazána.');
    }
}
