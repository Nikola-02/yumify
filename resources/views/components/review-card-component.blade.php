<div class="review-card">
    <div class="review-card-up">
        <h4>{{$rating->user->username}}</h4>
        <div class="review-card-stars">
            @for($i = 0; $i < 5; $i++)
                @if($i < $rating->stars)
                    <i class="fa-solid fa-star"></i>
                @else
                    <i class="fa-regular fa-star"></i>
                @endif
            @endfor

        </div>
    </div>
    <div class="review-card-down">"{{$rating->comment}}"</div>
    <div class="created-at">{{$rating->created_at}}</div>
</div>
