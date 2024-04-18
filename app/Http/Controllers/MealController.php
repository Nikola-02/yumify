<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use App\Models\Type;
use Illuminate\Http\Request;

class MealController extends OsnovniController
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
        return view('pages.admin.meals.create', ['restaurants'=>Restaurant::all(),'types'=>Type::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'restaurant_id'=>'required',
            'type_id'=>'required',
            'price'=>'required|gt:0'
        ]);

        $price = ['price'=>round(((float)$formFields['price']), 2)];

        unset($formFields['price']);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images');
                $formFields['image'] = basename($imagePath);
            }

            $meal = Meal::create($formFields);

            $this->log_action_for_user('New Meal created.');

            $meal->prices()->create($price);

            return redirect('/admin/meals')->with(['message'=>'Successfully created.']);
        }catch(\Exception $ex){
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
    public function edit(Request $request, Meal $meal)
    {
        return view('pages.admin.meals.edit', ['meal'=>$meal, 'restaurants'=>Restaurant::all(),'types'=>Type::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'restaurant_id'=>'required',
            'type_id'=>'required',
            'price'=>'required|gt:0'
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image'=>'mimes:jpg,jpeg,png'
            ]);
        }

        $price = ['price'=>round(((float)$formFields['price']), 2)];

        unset($formFields['price']);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images');
                $formFields['image'] = basename($imagePath);
            }

            $meal->update($formFields);

            $this->log_action_for_user('Meal updated.');

            $meal->prices()->create($price);

            return redirect('/admin/meals')->with(['message'=>'Successfully updated.']);
        }catch(\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        try {
            $meal->delete();

            $this->log_action_for_user('Meal deleted.');

            return response()->json($this->data_for_table('meals'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
