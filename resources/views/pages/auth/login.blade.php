@extends('layouts.layout')
@section('content')
    <div class="container mt-2 registerLogin-container">
        <div class="row mb-5 d-flex justify-content-center">
            <div class="col-md-6 text-center">
                @if (session('userCreated'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="alert alert-success" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="m-0">{{ session('userCreated') }}</p>
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
                <h2>Login</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <form action="{{route('performLogin')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com"/>
                        @error('email')
                            <p class="alert alert-danger mt-2">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"/>
                        @error('password')
                        <p class="alert alert-danger mt-2">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <p>Don't have an account? <a href="/register">Create one here</a></p>
                </form>
                @if(session('bad_credentials'))
                    <p class="alert alert-danger p-3 mt-3">{{session('bad_credentials')}}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
