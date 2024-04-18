$(document).ready(function(){
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let url = "http://localhost:8000/api/restaurants";
    let urlFlag = 'next';
    let result = null;
    function cutText(name, maxLength){
        let nameText = name.substring(0, maxLength);
        if (name.length > maxLength) {
            nameText += '...';
        }

        return nameText
    }

    function printTypes(types){
        return types.map(t=>t.name).join(', ')
    }

    function checkIfRestaurantIsOpened(r){
        let currentTime = new Date().getUTCHours() + 1;
        let open_in = new Date(`1970-01-01T${r.open_in}Z`).getUTCHours();
        let close_in = new Date(`1970-01-01T${r.close_in}Z`).getUTCHours();

        return currentTime >= open_in && currentTime < close_in
    }

    function printRating(r){
        let html = ``;

        if (r.ratings.length){
            html = `
                <div class="rating">
                    <i class="fa-solid fa-star"></i>
                    <span>${r.average_rating}</span>
                </div>
            `;
        }else{
            html = `
                    <div class="no-rating">
                        <div class="small">No reviews</div>
                    </div>
            `;
        }

        return html;
    }

    function printRestaurantsAndPages(restaurants){
        let html = ``;

        restaurants.data.forEach(r=>{
            html+=`
                <div class="col-md-5 ">
                            <a href="/restaurants/${r.id}">
                                <div class="restaurant-card">
                                    <div class="card-up">
                                        <div class="card-img">
                                            <img src="/storage/images/${r.image}" alt="${r.name}">
                                        </div>
                                        <div class="card-text">
                                            <div class="card-text-up">
                                                <div class="name">
                                                    <h4>
                                                        ${
                                                            cutText(r.name, 13)
                                                        }
                                                    </h4>
                                                    <div class="small">(click for details)</div>
                                                </div>

                                                ${printRating(r)}
                                            </div>
                                            <div class="card-text-down">
                                                ${
                                                    cutText(r.description, 80)
                                                }
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-down">
                                        <p>${printTypes(r.types)}</p>
                                        <span class="${checkIfRestaurantIsOpened(r) ? 'open-div' : 'closed-div'}">${checkIfRestaurantIsOpened(r) ? 'Open' : 'Closed'}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
            `;
        })

        //Print products
        $('.restaurants-listing').html(html);

        //Print pages
        $('.paginate-pages').html(`${restaurants.current_page} of ${Math.ceil(restaurants.total/restaurants.per_page)} pages`);
    }
    async function fetchRestaurants(){

        //Postavljanje url-a na koji treba da se posalje zahtev
        if(result != null){
            if(urlFlag == 'next'){
                url = result.next_page_url;
            }else if(urlFlag == 'prev'){
                url = result.prev_page_url;
            }
        }

        const response = await fetch(url, {
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
        });

        result = await response.json();

        if(result.next_page_url == null){
            $('.next-page').parent().addClass('disabled');
        }else{
            $('.next-page').parent().removeClass('disabled');
        }

        if(result.prev_page_url == null){
            $('.prev-page').parent().addClass('disabled');
        }else{
            $('.prev-page').parent().removeClass('disabled');
        }

        printRestaurantsAndPages(result)
    }

    //Inicijalni poziv funkcije za dohvatanje restorana
    fetchRestaurants();

    //On click next page
    $('.next-page').click(()=>{
        urlFlag = 'next'
        fetchRestaurants()
    })

    //On click prev page
    $('.prev-page').click(()=>{
        urlFlag = 'prev'
        fetchRestaurants()
    })
});
