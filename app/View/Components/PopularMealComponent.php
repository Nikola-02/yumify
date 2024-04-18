<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PopularMealComponent extends Component
{
    public $meal;
    /**
     * Create a new component instance.
     */
    public function __construct($meal)
    {
        $this->meal = $meal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.popular-meal-component');
    }
}
