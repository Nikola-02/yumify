<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends OsnovniController
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
        return view('pages.admin.types.create');
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
            Type::create($formFields);

            $this->log_action_for_user('New Type created.');

            return redirect('/admin/types')->with(['message'=>'Successfully created.']);
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
    public function edit(Type $type)
    {
        return view('pages.admin.types.edit', ['type'=>$type]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $formFields = $request->validate([
            'name'=>'required'
        ]);

        try {
            $type->update($formFields);

            $this->log_action_for_user('Type updated.');

            return redirect('/admin/types')->with(['message'=>'Successfully updated.']);
        }catch (\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        try {
            $type->delete();

            $this->log_action_for_user('Type deleted.');

            return response()->json($this->data_for_table('types'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
