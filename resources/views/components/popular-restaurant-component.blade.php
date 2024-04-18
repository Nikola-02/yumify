<a href="/restaurants/{{$restaurant->id}}">
    <div class="popular-restaurants-card">
        <div class="popular-restaurants-img">
            <img src="{{asset('assets/images/'.$restaurant->image)}}" alt="{{$restaurant->name}}">
        </div>
        <div class="popular-restaurants-text">
            <h5>{{$restaurant->name}}</h5>
            <div class="food-rating">
                <i class="fa-solid fa-star {{$restaurant->average_rating ? '' : 'd-none'}}"></i><span>{{$restaurant->average_rating ?? 'No reviews'}}</span>
            </div>
        </div>
        <div class="popular-restaurants-opened-btn-div {{$restaurant->opened ? 'open-div' : 'closed-div'}}">
            <span>{{$restaurant->opened ? 'Open' : 'Closed'}}</span>
        </div>
    </div>
</a>
