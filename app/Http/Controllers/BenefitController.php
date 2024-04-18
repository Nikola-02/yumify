<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends OsnovniController
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
        return view('pages.admin.benefits.create');
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
            Benefit::create($formFields);

            $this->log_action_for_user('New Benefit created.');

            return redirect('/admin/benefits')->with(['message'=>'Successfully created.']);
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
    public function edit(Benefit $benefit, Request $request)
    {
        return view('pages.admin.benefits.edit', ['benefit'=>$benefit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Benefit $benefit)
    {
        $formFields = $request->validate([
            'name'=>'required'
        ]);

        try {
            $benefit->update($formFields);

            $this->log_action_for_user('Benefit updated.');

            return redirect('/admin/benefits')->with(['message'=>'Successfully updated.']);
        }catch (\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Benefit $benefit)
    {
        try {
            $benefit->delete();

            $this->log_action_for_user('Benefit deleted.');

            return response()->json($this->data_for_table('benefits'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
