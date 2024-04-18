@extends('layouts.layout')
@section('content')
<div class="single-restaurant">
    <div class="single-restaurant-container">
        <div class="single-restaurant-heading">
            <h2>Restaurant info</h2>
        </div>
        <div class="single-restaurant-card">
            <div class="single-restaurant-row">
                <div class="col-md-5 img-div">
                    <img src="{{asset('storage/images/' . $restaurant->image)}}" alt="{{$restaurant->name}}"/>
                </div>
                <div class="col-md-5 text-div">
                    <div class="name-opened">
                        <h4 class="m-0">{{$restaurant->name}}</h4>
                        <span class="{{$restaurant->opened  ? 'open-div' : 'closed-div'}}">{{$restaurant->opened  ? ' Open' : 'Closed'}}</span>
                    </div>
                    <div class="rating">
                        @if(count($restaurant->ratings))
                            <i class="fa-solid fa-star"></i>
                            @if($restaurant->average_rating)
                            <span class="avg-rating">{{$restaurant->average_rating}}</span>
                            <div class="small based-on">(Based on {{count($restaurant->ratings)}} reviews)</div>
                            @endif
                        @else
                            <div class="small ">No reviews for this restaurant</div>
                        @endif
                    </div>
                    <div class="desc">{{$restaurant->description}}</div>
                    <span class="small food-type">{{implode(', ',$restaurant->types->pluck('name')->toArray())}}</span>
                    <span class="location"><i class="fa-solid fa-location-dot"></i> {{$restaurant->location}}</span>
                    <span class="working-hours"><i class="fa-solid fa-clock"></i>{{substr($restaurant->open_in,0,5)}}h - {{substr($restaurant->close_in,0,5)}}h</span>
                    @if(count($restaurant->benefits) > 0)
                        <span class="services"><i class="fa-solid fa-utensils"></i>{{implode(', ',$restaurant->benefits->pluck('name')->toArray())}}</span>
                    @else
                        <span class="small">No benefits</span>
                    @endif
                    <a class="menu-btn btn {{session('user') ? '' : 'disabled'}}" href="/restaurants/{{$restaurant->id}}/menu">MENU</a>
                    @if(!session('user'))
                        <span class="small">(Log in to view menu)</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="single-restaurant-reviews">
            <div class="reviews-heading">
                <div class="heading-text">
                    <h2 class="m-0">Reviews</h2>
                    <span class="small count-reviews"> ({{count($restaurant->ratings)}} reviews)</span>
                </div>
                <div class="heading-btn">
                    @if(session('user'))
                        <button type="button" data-bs-toggle="modal" data-bs-target="#review-modal" class="btn">Leave a review</button>
                    @else
                        <div class="small">(Log in to leave a review)</div>
                    @endif
                </div>


            </div>
            <div class="reviews-content">
                @if(count($restaurant->ratings))
                    @foreach($restaurant->ratings as $rating)
                        <x-review-card-component :rating="$rating"/>
                    @endforeach
                @else
                        <div class="small alert alert-danger no-reviews">No reviews for this restaurant</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="review-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Your review</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-3 stars-parent">
                        <label for="commentField" class="form-label">Rate (1-5)</label>
                        <br>
                        <div class="stars"></div>
                    </div>
                    <div class="mb-3">
                        <label for="comment_field" class="form-label">Comment</label>
                        <textarea class="form-control" placeholder="Leave a comment here" id="comment_field"></textarea>
                    </div>
                </form>
                <div class="alert alert-danger errors-rating d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn save-review-btn">Save</button>
            </div>
        </div>
    </div>
</div>

{{--  Notification  --}}
<div class="alert alert-success notification-single-restaurant d-none">Thanks for review!</div>
@endsection
@section('script')
    <script src="{{asset('assets/js/single-restaurant.js')}}"></script>
@endsection
