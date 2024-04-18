@extends('layouts.layout')
@section('content')
    <div class="container mt-2 registerLogin-container">
        <div class="row mb-5 d-flex justify-content-center">
            <div class="col-md-6 text-center">
                @if (session('registrationError'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="alert alert-danger" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="m-0">{{ session('registrationError') }}</p>
                            <button @click="show = false" class="close btn" type="button">
                                <i class="fa-solid fa-xmark "></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 text-center">
                <h2 >Register</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <form action="{{route('performRegister')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="example123" value="{{old('username')}}"/>
                        @error('username')
                            <p class="alert alert-danger mt-2">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address *</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com" value="{{old('email')}}"/>
                        @error('email')
                            <p class="alert alert-danger mt-2">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}"/>
                        <div id="passwordHelp"  class="form-text">Min. 6 characters, at least 1 number and 1 letter</div>
                        @error('password')
                            <p class="alert alert-danger mt-2">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="order_location" class="form-label">Order location</label>
                        <input type="text" name="order_location" class="form-control" id="order_location" value="{{old('order_location')}}"/>
                        <div id="orderLocationHelp" class="form-text">(Not required, you can add it later)</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <p>Already have an account? <a href="/login">Log in here</a></p>
                </form>
            </div>
        </div>
    </div>
@endsection


