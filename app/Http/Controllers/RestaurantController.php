<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\Type;
use Illuminate\Http\Request;

class RestaurantController extends OsnovniController
{
    public function index(){
        return view('pages.restaurants.index');
    }

    public function apiIndex(){
        $restaurants = Restaurant::with('types', 'ratings')->paginate(6);
        foreach ($restaurants as $restaurant){
            if(count($restaurant->ratings)){
                $array_of_ratings = $restaurant->ratings->pluck('stars');
                $restaurant->average_rating = round($array_of_ratings->avg(), 1);
            }
        }
        return response()->json($restaurants);
    }

    public function show($id){

        $restaurant = Restaurant::with(['ratings' => function($query) {
            $query->latest('created_at');
        }, 'ratings.user'])->find($id);

        if($restaurant){
            $currentTime = gmdate('H') + 1;
            $open_in = date('H', strtotime($restaurant->open_in));
            $close_in = date('H', strtotime($restaurant->close_in));

            $restaurant->opened = $currentTime >= $open_in && $currentTime < $close_in;

            if(count($restaurant->ratings)){
                $array_of_ratings = $restaurant->ratings->pluck('stars');
                $restaurant->average_rating = round($array_of_ratings->avg(), 1);
            }

            return view('pages.restaurants.show', ['restaurant'=>$restaurant]);
        }else{
            return redirect()->route('home');
        }

    }

    public function postReview(Restaurant $restaurant, Request $request){
        $formFields = $request->validate([
            'stars'=>'required',
            'comment'=>'required'
        ]);

        $userFromSession = session()->get('user');
        $formFields['user_id'] = $userFromSession->id;
        $formFields['restaurant_id'] = $restaurant->id;

        try {
            $rating = Rating::create($formFields);
            $ratingsArrayForRestaurant = Rating::where('restaurant_id', $restaurant->id)->pluck('stars');
            $newRatingForRestaurant = round($ratingsArrayForRestaurant->avg(), 1);

            $this->log_action_for_user('Posted review for restaurant.');

            return response()->json(['rating'=>$rating->load('user'), 'ratingsCountForRestaurant'=>count($ratingsArrayForRestaurant),'newRatingForRestaurant'=>$newRatingForRestaurant]);
        }catch (\Exception $ex){
            return response()->json($ex->getMessage());
        }


    }

    public function showMenu(Restaurant $restaurant){
        return view('pages.restaurants.menu', ['restaurant'=>$restaurant, 'types'=>Type::all()]);
    }

    public function apiMealsMenu(Restaurant $restaurant, Request $request){
        $meals = $restaurant->meals()->with(['type', 'prices'])->filter(request(['search', 'sort', 'food_type']))->paginate(6);


        return response()->json([
            'restaurant' => $restaurant,
            'meals' => $meals,
        ]);

        //return response()->json($restaurant->load(['meals', 'meals.type']));
    }
}
