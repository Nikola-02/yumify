@extends('layouts.layout')
@section('content')
<div class="order-div">
    <div class="order-container">
        <div class="order-heading">
            <h2>Your order cart</h2>
        </div>
        <div class="row order-content">
            <div class="col-md-4 checkout d-none">
                <div class="checkout-heading mb-2">
                    <h4>Checkout</h4>
                </div>
                <div class="checkout-content">
                    <div class="small">SHIPPING DETAILS</div>
                    <div class="mb-3 location-div">
                        <label for="location" class="form-label location-label">Location</label>
                        <input type="text" id="location" class="form-control" placeholder="Enter your order location"/>
                        <a class="set-primary-location-btn">Set entered location as primary</a>
                    </div>
                    <div class="total-price">
                        <div class="small">TOTAL PRICE</div>
                        <div class="subtotal show-price-div mb-1">
                            <span class="subtotal-text">Subtotal</span>
                            <span class="subtotal-amount"></span>
                        </div>
                        <div class="delivery show-price-div mb-1">
                            <span class="delivery-text">Delivery</span>
                            <span class="delivery-amount">$ 0.50</span>
                        </div>
                        <div class="total show-price-div mb-1">
                            <span class="total-text"><strong>Total</strong></span>
                            <span class="total-amount"><strong>$</strong> <strong class="total-price-amount"></strong></span>
                        </div>
                    </div>
                    <div class="order-now-div">
                        <button class="btn order-now-btn">Order now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7 order-cart"></div>
        </div>
    </div>
</div>

    <div class="alert alert-danger notification-order-error d-none"></div>

    <div class="alert alert-success notification-order-quantity-updated d-none">Successfully updated quantity of item.</div>

    <div class="alert alert-success notification-location-updated d-none"></div>
@endsection
@section('script')
    <script src="{{asset('assets/js/order.js')}}"></script>
@endsection
