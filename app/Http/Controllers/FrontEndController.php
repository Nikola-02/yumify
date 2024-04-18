<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class FrontEndController extends OsnovniController
{
    public function index(){
        return view('pages.home', [
            'popular_meals'=>Meal::with('restaurant')->take(4)->get(),
            'popular_restaurants'=>Restaurant::with('ratings')->take(8)->get()
        ]);
    }

    public function author(){
        return view('pages.author');
    }
}
