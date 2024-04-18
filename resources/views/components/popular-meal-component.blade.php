<div class="popular-meal-card">
    <div class="popular-meal-img">
        <img src="{{asset('assets/images/'.$meal->image)}}" alt="{{$meal->name}}">
    </div>
    <div class="popular-meal-text">
        <div class="popular-meal-upper-text">
            <h5 class="m-0">{{$meal->name}}</h5>
            <p class="m-0">$ {{$meal->trigger_price}}</p>
        </div>
        <div class="popular-meal-down-text">
            <div class="restaurant-location">
                <i class="fa-solid fa-location-dot"></i><span>{{$meal->restaurant->name}}</span>
            </div>
        </div>
    </div>
</div>
