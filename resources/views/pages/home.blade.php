@extends('layouts.layout')
@section('content')
    <div class="hero-div">
        <div class="hero-container">
            <div class="hero-text">
                <h2>Discover Culinary Delights</h2>
                <p>Within a few clicks, find  your favorite meals</p>
                <a href="/restaurants">Take a tour</a>
            </div>
            <div class="hero-img">
                <img src="{{asset('assets/images/hero.png')}}" alt="Plate with lemon and other vegetables">
            </div>
        </div>
        @if (session('success_login'))
        <div class="notification">
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-200" class="alert alert-success" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0">{{ session('success_login') }}</p>
                    <button @click="show = false" class="close btn" type="button">
                        <i class="fa-solid fa-xmark "></i>
                    </button>
                </div>
            </div>

        </div>
        @endif
    </div>
    {{--  POPULAR MEALS  --}}
    <div class="popular-meals-div">
        <div class="popular-meals-container">
            <div class="popular-meals-heading">
                <h2>Popular meals</h2>
            </div>
            <div class="popular-meals-content">
                @foreach($popular_meals as $meal)
                    <x-popular-meal-component :meal="$meal"/>
                @endforeach

            </div>
        </div>
    </div>

    {{--  POPULAR RESTAURANTS  --}}
    <div class="popular-restaurants-div">
        <div class="popular-restaurants-container">
            <div class="popular-restaurants-heading">
                <h2>Popular restaurants</h2>
            </div>
            <div class="popular-restaurants-content">
                <div class="popular-restaurants-content-row">

                    @foreach($popular_restaurants as $rest)
                        <x-popular-restaurant-component :restaurant="$rest"/>
                    @endforeach
                </div>
{{--                <div class="popular-restaurants-content-row">--}}
{{--                    <a href="/restaurants/1">--}}
{{--                        <div class="popular-restaurants-card">--}}
{{--                            <div class="popular-restaurants-img">--}}
{{--                                <img src="{{asset('assets/images/popular_restaurant.png')}}" alt="Popular restaurant">--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-text">--}}
{{--                                <h5>KFC Food</h5>--}}
{{--                                <div class="food-rating">--}}
{{--                                    <i class="fa-solid fa-star"></i><span>4.9</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-opened-btn-div open-div">--}}
{{--                                <span>Open</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <a href="/restaurants/1">--}}
{{--                        <div class="popular-restaurants-card">--}}
{{--                            <div class="popular-restaurants-img">--}}
{{--                                <img src="{{asset('assets/images/popular_restaurant.png')}}" alt="Popular restaurant">--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-text">--}}
{{--                                <h5>KFC Food</h5>--}}
{{--                                <div class="food-rating">--}}
{{--                                    <i class="fa-solid fa-star"></i><span>4.9</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-opened-btn-div open-div">--}}
{{--                                <span>Open</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <a href="/restaurants/1">--}}
{{--                        <div class="popular-restaurants-card">--}}
{{--                            <div class="popular-restaurants-img">--}}
{{--                                <img src="{{asset('assets/images/popular_restaurant.png')}}" alt="Popular restaurant">--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-text">--}}
{{--                                <h5>KFC Food</h5>--}}
{{--                                <div class="food-rating">--}}
{{--                                    <i class="fa-solid fa-star"></i><span>4.9</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-opened-btn-div open-div">--}}
{{--                                <span>Open</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <a href="/restaurants/1">--}}
{{--                        <div class="popular-restaurants-card">--}}
{{--                            <div class="popular-restaurants-img">--}}
{{--                                <img src="{{asset('assets/images/popular_restaurant.png')}}" alt="Popular restaurant">--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-text">--}}
{{--                                <h5>KFC Food</h5>--}}
{{--                                <div class="food-rating">--}}
{{--                                    <i class="fa-solid fa-star"></i><span>4.9</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="popular-restaurants-opened-btn-div open-div">--}}
{{--                                <span>Open</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
