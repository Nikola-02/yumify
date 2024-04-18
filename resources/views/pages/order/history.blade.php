@extends('layouts.layout')
@section('content')
    <div class="order-history">
        <div class="order-history-container">
            <div class="order-history-heading">
                <h2>Your orders</h2>
            </div>
            @if(count($orders) > 0)
                <div class="col-md-7">
                    @foreach($orders as $order)
                        <div class="order-history-card">
                            <div class="lines">
                                <h5 class="title">Order</h5>
                                <div class="user-location">
                                    <p>Location: {{$order->ordered_on_location}}</p>
                                    <h5>Total: $ {{$order->total_price}}</h5>
                                </div>
                                @foreach($order->orderLines as $line)
                                    <div class="line-card">
                                        <div class="col-md-4 text-start"><h6>{{$line->meal->name}}</h6></div>
                                        <div class="col-md-4"><p class="m-0">Quantity: {{$line->quantity}}</p></div>
                                        <div class="col-md-4 text-end"><p class="m-0">$ {{$line->meal->trigger_price}}</p></div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger">There is no previous orders</div>
            @endif
        </div>
    </div>
@endsection
