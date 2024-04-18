<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Restaurant;
use App\Models\Type;
use Illuminate\Http\Request;

class RestaurantAdminController extends OsnovniController
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
        return view('pages.admin.restaurants.create', ['types'=>Type::all(), 'benefits'=>Benefit::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'open_in' => 'required',
            'close_in' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'types'=>'required',
            'benefits'=>'required',
        ]);

        $types = $formFields['types'];
        $benefits = $formFields['benefits'];

        unset($formFields['types']);
        unset($formFields['benefits']);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images');
                $formFields['image'] = basename($imagePath);
            }

            $restaurant = Restaurant::create($formFields);

            $this->log_action_for_user('New Restaurant created.');

            $restaurant->types()->attach($types);
            $restaurant->benefits()->attach($benefits);

            return redirect('/admin/restaurants')->with(['message'=>'Successfully created.']);
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
    public function edit(Restaurant $restaurant)
    {
        return view('pages.admin.restaurants.edit', ['restaurant'=>$restaurant->load('types', 'benefits'),'types'=>Type::all(), 'benefits'=>Benefit::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'open_in' => 'required',
            'close_in' => 'required',
            'types'=>'required',
            'benefits'=>'required',
        ]);

        $types = $formFields['types'];
        $benefits = $formFields['benefits'];

        unset($formFields['types']);
        unset($formFields['benefits']);

        if ($request->hasFile('image')) {
            $request->validate([
                'image'=>'mimes:jpg,jpeg,png'
            ]);
        }

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images');
                $formFields['image'] = basename($imagePath);
            }

            $restaurant->update($formFields);

            $this->log_action_for_user('Restaurant updated.');

            $restaurant->types()->sync($types);
            $restaurant->benefits()->sync($benefits);

            return redirect('/admin/restaurants')->with(['message'=>'Successfully updated.']);
        }catch(\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        try {
            $restaurant->delete();

            $this->log_action_for_user('Restaurant deleted.');

            return response()->json($this->data_for_table('restaurants'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
