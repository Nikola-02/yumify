<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends OsnovniController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name'=>'required'
        ]);

        try {
            Role::create($formFields);

            $this->log_action_for_user('New Role created.');

            return redirect('/admin/roles')->with(['message'=>'Successfully created.']);
        }catch (\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('pages.admin.roles.edit', ['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $formFields = $request->validate([
            'name'=>'required'
        ]);

        try {
            $role->update($formFields);

            $this->log_action_for_user('Role updated.');

            return redirect('/admin/roles')->with(['message'=>'Successfully updated.']);
        }catch (\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();

            $this->log_action_for_user('Role deleted.');

            return response()->json($this->data_for_table('roles'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
