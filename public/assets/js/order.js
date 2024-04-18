$(document).ready(function(){
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function printUsersLocation(user){
        if(user.order_location){
            $('#location').val(user.order_location)
        }
    }
    function printOrderItems(items){
        let html = ``;
        if(items.length){
            $('.checkout').removeClass('d-none');
            items.forEach(i=>{
                html +=`
                    <div class="order-item px-4 mb-4">
                        <div class="img-name-restaurant-container">
                            <div class="order-item-img">
                                <img src="/storage/images/${i.meal.image}" alt="${i.meal.name}" />
                            </div>
                            <div class="order-name-restaurant">
                                <h5>${i.meal.name}</h5>
                                <span class="small">${i.meal.restaurant.name}</span>
                            </div>
                        </div>

                        <div class="order-item-unit-price">
                            $ <span>${i.meal.trigger_price}</span>
                        </div>
                        <div class="order-item-quantity">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" value="${i.quantity}" data-id="${i.id}" id="quantity"/>
                        </div>
                        <div class="order-item-remove-btn">
                            <i class="fa-regular fa-circle-xmark remove-item-from-order-btn" data-id="${i.id}"></i>
                        </div>
                    </div>
            `;
            })

            $('.order-cart').html(html)
        }else{
            html = `<div class="alert alert-danger">There is no items in order</div>`;

            $('.order-content').html(html)
        }



        //Print Total price
        let delivery_price = 0.50;
        let subtotal = 0;
        items.forEach(i=>{
            subtotal+= i.meal.trigger_price * i.quantity
        })
        $('.subtotal-amount').html(subtotal.toFixed(2));
        $('.total-price-amount').html((subtotal + delivery_price).toFixed(2));

    }

    async function fetchUserLocation(){
        let url = new URL(`http://localhost:8000/user/location`)

        await fetch(url, {
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            }
        }).then(response => response.json())
            .then(data => {
                printUsersLocation(data)
            })
            .catch(error => {
                $('.notification-order-error').removeClass('d-none');
                $('.notification-order-error').html('Error occurred while displaying order items.');

                setTimeout(()=>{
                    $('.notification-order-error').addClass('d-none');
                },4000);
            });
    }

    async function fetchOrder(){
        let url = new URL(`http://localhost:8000/order/api`)

        await fetch(url, {
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            }
        }).then(response => response.json())
            .then(data => {
                printOrderItems(data)
                fetchUserLocation()
            })
            .catch(error => {
                $('.notification-order-error').removeClass('d-none');
                $('.notification-order-error').html('Error occurred while displaying order items.');

                setTimeout(()=>{
                    $('.notification-order-error').addClass('d-none');
                },4000);
            });
    }

    //Inicijalni fetch order items
    fetchOrder()

    //Print updated quantity notification
    function printNotification(data){
        $('.notification-order-quantity-updated').removeClass('d-none');

        setTimeout(()=>{
            $('.notification-order-quantity-updated').addClass('d-none');
        },4000);
    }

    //Update quantity function
    async function updateQuantity(new_quantity, order_line_id){
        let url = new URL(`http://localhost:8000/order/line/${order_line_id}/quantity`)

        await fetch(url, {
            method: "PUT",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                'quantity':+new_quantity
            }),
            credentials: 'include'
        }).then(response => response.json())
            .then(data => {
                printNotification()
                printOrderItems(data)
            })
            .catch(error => {
                $('.notification-order-error').removeClass('d-none');
                $('.notification-order-error').html('Error occurred while displaying order items.');

                setTimeout(()=>{
                    $('.notification-order-error').addClass('d-none');
                },4000);
            });
    }

    //On focusout quantity update
    $(document).on("focusout", '#quantity', function() {
        if($(this).val() <= 0){
            $(this).val(1)
        }else{
            updateQuantity($(this).val(), $(this).data('id'))
        }
    })

    async function removeItemFromOrder(order_line_id){
        let url = new URL(`http://localhost:8000/order/line/${order_line_id}`)

        await fetch(url, {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
            credentials: 'include'
        }).then(response => response.json())
            .then(data => {
                printOrderItems(data)
            })
            .catch(error => {
                $('.notification-order-error').removeClass('d-none');
                $('.notification-order-error').html('Error occurred while displaying order items.');

                setTimeout(()=>{
                    $('.notification-order-error').addClass('d-none');
                },4000);
            });
    }

    //On click remove item from order
    $(document).on("click", '.remove-item-from-order-btn', function() {
        removeItemFromOrder($(this).data('id'))
    })

    //Print location updated notification
    function printNotificationLocationAndOrderCartSuccess(data){
        $('.notification-location-updated').removeClass('d-none');
        $('.notification-location-updated').html(data);

        setTimeout(()=>{
            $('.notification-location-updated').addClass('d-none');
        },4000);
    }

    //Set primary location function
    async function setPrimaryLocation(location){
        let url = new URL(`http://localhost:8000/user/location`)

        await fetch(url, {
            method: "PUT",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                'location':location
            }),
            credentials: 'include'
        }).then(response => response.json())
            .then(data => {
                printNotificationLocationAndOrderCartSuccess(data.message)
            })
            .catch(error => {
                $('.notification-order-error').removeClass('d-none');
                $('.notification-order-error').html('Error occurred while displaying order items.');

                setTimeout(()=>{
                    $('.notification-order-error').addClass('d-none');
                },4000);
            });
    }

    //Set primary location btn
    $(document).on("click", '.set-primary-location-btn', function() {
        if($('#location').val()){
            $('.location-label').removeClass('location-label-error');
            $('#location').removeClass('location-error');
            setPrimaryLocation($('#location').val())
        }else{
            $('.location-label').addClass('location-label-error');
            $('#location').addClass('location-error');
        }
    })

    //Order now function
    async function orderCart(location){
        let url = new URL(`http://localhost:8000/order/user`)

        await fetch(url, {
            method: "PUT",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                'location':location,
            }),
            credentials: 'include'
        }).then(response => response.json())
            .then(data => {
                printOrderItems(data.items)
                printNotificationLocationAndOrderCartSuccess(data.message)
            })
            .catch(error => {
                $('.notification-order-error').removeClass('d-none');
                $('.notification-order-error').html('Error occurred while displaying order items.');

                setTimeout(()=>{
                    $('.notification-order-error').addClass('d-none');
                },4000);
            });
    }

    //Order now click
    $(document).on("click", '.order-now-btn', function() {
        if($('#location').val()){
            $('.location-label').removeClass('location-label-error');
            $('#location').removeClass('location-error');

            orderCart($('#location').val())
        }else{
            $('.location-label').addClass('location-label-error');
            $('#location').addClass('location-error');
        }
    })
})
