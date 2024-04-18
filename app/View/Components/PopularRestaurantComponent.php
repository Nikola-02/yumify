<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PopularRestaurantComponent extends Component
{
    public $restaurant;
    /**
     * Create a new component instance.
     */
    public function __construct($restaurant)
    {
        $this->restaurant = $restaurant;

        //cut text name
        if(count_chars($this->restaurant->name) > 12){
            $this->restaurant->name = substr($this->restaurant->name,0,10) . '...';
        }

        //Add average rating
        if(count($this->restaurant->ratings)){
            $array_of_ratings = $this->restaurant->ratings->pluck('stars');
            $this->restaurant->average_rating = round($array_of_ratings->avg(), 1);
        }else{
            $this->restaurant->average_rating = null;
        }

        //Add opened or closed
        $currentTime = gmdate('H') + 1;
        $open_in = date('H', strtotime($this->restaurant->open_in));
        $close_in = date('H', strtotime($this->restaurant->close_in));

        $this->restaurant->opened = $currentTime >= $open_in && $currentTime < $close_in;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.popular-restaurant-component');
    }
}
