$(document).ready(function(){
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var pathArray = window.location.pathname.split('/');
    var restaurantId = pathArray[pathArray.length - 2];
    let timeout = null;

    let url = new URL(`http://localhost:8000/restaurants/api/${restaurantId}/menu`)
    let urlFlag = null;
    let result = null

    function printPages(meals){
        //Print pages
        $('.paginate-pages').html(`${meals.current_page} of ${Math.ceil(meals.total/meals.per_page)} pages`);
    }
    function printMeals(data){
        if(data.meals.data.length){
            $('.pagination-menu-meals').removeClass('d-none')
            $('.menu-items').removeClass('d-block')
            let html = ``;

            data.meals.data.forEach(m=>{
                html+=`
                <div class="col-md-10">
                            <div class="menu-item">
                                <div class="item-image">
                                    <img src="/storage/images/${m.image}" alt="${m.name}"/>
                                </div>
                                <div class="item-text">
                                    <div class="item-text-upper">
                                        <h5>${m.name}</h5>
                                        <span>$ ${m.trigger_price}</span>
                                    </div>
                                    <div class="item-text-middle">
                                        <p>${m.description}</p>
                                    </div>
                                    <div class="item-text-down">
                                        <p>${m.type.name}</p>
                                    </div>
                                    <div class="item-btn">
                                        <button class="btn" id="add-to-order-btn" data-id="${m.id}">Add to order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;
            });

            $('.menu-items').html(html);

            printPages(data.meals)
        }else{
            $('.pagination-menu-meals').addClass('d-none')
            $('.menu-items').addClass('d-block')
            $('.menu-items').html(`<div class='alert alert-danger p-4'>There is no meals for your input.</div>`);
        }

    }

    function resetUrl(){
        url = new URL(`http://localhost:8000/restaurants/api/${restaurantId}/menu`)
    }
    async function fetchMenu(){
        resetUrl()
        //Postavljanje url-a na koji treba da se posalje zahtev
        if(result != null){
            if(urlFlag == 'next'){
                url = new URL(result.meals.next_page_url);
            }else if(urlFlag == 'prev'){
                url = new URL(result.meals.prev_page_url);
            }
        }

        //Slanje filter, search i sort parametara
        let sort_value = $("#sort-meals").val();
        let params = new URLSearchParams(url.search.slice(1));

        if(sort_value != 0){
            params.append('sort', sort_value);
        }

        if($("#search-meals").val()){
            params.append('search', $("#search-meals").val());
        }

        if($(".food-type-ch:checked").length){
            let checked = []
            $(".food-type-ch:checked").each(function(){
                params.append('food_type[]', $(this).val());
            })
        }

        url.search = params.toString();

        await fetch(url, {
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            }
        }).then(response => response.json())
            .then(data => {
                result = data
                printMeals(data)
            })
            .catch(error => {
                $('.notification-meals-menu').removeClass('d-none');
                $('.notification-meals-menu').html('Error occurred while displaying menu.');

                setTimeout(()=>{
                    $('.notification-meals-menu').addClass('d-none');
                },4000);
            });

        if(result.meals.next_page_url == null){
            $('.next-page').parent().addClass('disabled');
        }else{
            $('.next-page').parent().removeClass('disabled');
        }

        if(result.meals.prev_page_url == null){
            $('.prev-page').parent().addClass('disabled');
        }else{
            $('.prev-page').parent().removeClass('disabled');
        }
    }

    //Inicijalni fetch
    fetchMenu()

    //On click next page
    $('.next-page').click(()=>{
        urlFlag = 'next'
        fetchMenu()
        urlFlag = null;

    })

    //On click prev page
    $('.prev-page').click(()=>{
        urlFlag = 'prev'
        fetchMenu()
        urlFlag = null;
    })

    //On change food_type fetch
    $(document).on("change", '.food-type-ch', function() {
        fetchMenu()
    })

    //On keyup food_type fetch
    $(document).on("keyup", '#search-meals', function() {
        fetchMenu()
    })

    //On change sort fetch
    $(document).on("change", '#sort-meals', function() {
        fetchMenu()
    })


    //Add to order click
    $(document).on("click", '#add-to-order-btn', function() {
        addToOrder($(this).data('id'))
    })

    //Print add to cart notification
    function printNotification(data){
        $('.notification-added-to-cart').removeClass('d-none');
        $('.notification-added-to-cart').html(data.message);

        if(timeout){
            clearTimeout(timeout)
        }

        timeout = setTimeout(()=>{
            $('.notification-added-to-cart').addClass('d-none');
        },3000);
    }

    function printErrorForAddToCart(data){
        $('.notification-meals-menu').removeClass('d-none');
        $('.notification-meals-menu').html(data.message);

        setTimeout(()=>{
            $('.notification-meals-menu').addClass('d-none');
        },4000);
    }

    //Add to order function
    async function addToOrder(meal_id){
        let orderUrl = `http://localhost:8000/order/meal`

        await fetch(orderUrl, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                'meal_id': meal_id,
            }),
            credentials: 'include'
        }).then(response => response.json())
            .then(data => {
                printNotification(data)
            })
            .catch(error => {
                printErrorForAddToCart(error)
            });
    }
})
