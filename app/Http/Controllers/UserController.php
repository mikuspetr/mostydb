<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\Models\User::get();
        $roles = \Spatie\Permission\Models\Role::all();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return View('users.index', compact('users', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return View('users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users,login',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);
        //dd($validated);

        $user = new \App\Models\User;

        $user->name = $validated['name'];
        $user->login = $validated['login'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);

        $user->save();

        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }
        if (!empty($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        }

        return redirect()->route('users.show', $user->id)->with('success', 'Pracovník úspěšně vytvořen.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\Models\User::find($id);
        $roles = \Spatie\Permission\Models\Role::all();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return View('users.show', compact('user', 'roles', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = \App\Models\User::find($id);
        $user->syncRoles($request->input('roles', []));
        return redirect()->route('users.show', $id)->with('success', 'Oprávnění uživatele aktualizována.');
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
