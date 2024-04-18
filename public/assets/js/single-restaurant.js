$(document).ready(function(){
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let selected_star = -1;
    function printStars(index = -1){
        html = ``;

        for (let i = 0; i < 5; i++){
            if(index != -1){
                if(i <= index){
                    html+=`<i class="fa-solid fa-star" data-index="${i}"></i>`;
                }else{
                    html+=`<i class="fa-regular fa-star" data-index="${i}"></i>`;
                }
            }else{
                html+=`<i class="fa-regular fa-star" data-index="${i}"></i>`;
            }
        }

        $('.stars').html(html);
    }

    function printsStarsInReview(index) {
        html = ``;
        for (let i = 0; i < 5; i++){
            if (i < index) {
                html += `<i class="fa-solid fa-star"></i>`
            } else {
                html += `<i class="fa-regular fa-star"></i>`
            }
        }

        return html;
    }

    function dateOfReviewFormatting(date){
        return date.toISOString().slice(0, 19).replace('T', ' ');
    }

    function printReviews(data){
        let rating = data.rating;
        let averageRating = data.newRatingForRestaurant;
        let ratingsCountForRestaurant = data.ratingsCountForRestaurant;

        let html = `
            <div class="review-card">
                    <div class="review-card-up">
                        <h4>${rating.user.username}</h4>
                        <div class="review-card-stars">
                            ${printsStarsInReview(rating.stars)}
                        </div>
                    </div>
                    <div class="review-card-down">"${rating.comment}"</div>
                    <div class="created-at">${dateOfReviewFormatting(new Date(rating.created_at))}</div>
               </div>
        `;

        $('.no-reviews').addClass('d-none');
        $(".reviews-content").prepend(html);

        //Avg rating update UI
        $('.avg-rating').html(averageRating);

        //Reviews count update UI
        $('.rating').html(`
                            <i class="fa-solid fa-star"></i>
                            <span class="avg-rating">${averageRating}</span>
                            <div class="small based-on">(Based on ${ratingsCountForRestaurant} reviews)</div>
                        `);

        $('.count-reviews').html(` (${ratingsCountForRestaurant} reviews)`);

        $('.notification-single-restaurant').removeClass('d-none');

        setTimeout(()=>{
            $('.notification-single-restaurant').addClass('d-none');
        },4000);

    }
    function checkForErrors(){
        let errors = [];

        if(selected_star < 1){
            errors.push('You have to rate.');
        }

        if(!$('#comment_field').val()){
            errors.push('Comment is required.');
        }

        return errors;

    }

    async function postReview(comment){
        var pathArray = window.location.pathname.split('/');
        var restaurantId = pathArray[pathArray.length - 1];

        let url = `http://localhost:8000/restaurants/${restaurantId}/rating`
        await fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                'stars': selected_star,
                'comment': comment
            }),
            credentials: 'include'
        }).then(response => response.json())
            .then(data => {
                printReviews(data)
                $('.errors-rating').addClass('d-none');
                $('#review-modal').modal('hide');
                printStars()
                $('#comment_field').val('')
                selected_star = -1;

            })
            .catch(error => {
                console.log('da')
                $('.errors-rating').removeClass('d-none');
                $('.errors-rating').html(error)
            });

    }
    printStars();

    //Stavljanje zvezdica
    $(document).on("click", '.fa-star', function() {
        let index = $(this).data('index');
        selected_star = index + 1;
        printStars(index);
    })

    //Save review
    $('.save-review-btn').click(function() {
        let errors = checkForErrors();
        if(errors.length){
            $('.errors-rating').removeClass('d-none');
            $('.errors-rating').html(errors.join('<br/>'))
        }else{
            postReview($('#comment_field').val())

        }
    });

})
