@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-pages-heading text-center mb-5 mt-1">
            <h1>User - create form</h1>
        </div>
        <div class="page-form d-flex justify-content-center">
            <div class="col-md-5">
                <form action="/admin/users" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="example" id="username" value="{{old('username')}}"/>
                        @error('username')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" id="email" value="{{old('email')}}"/>
                        @error('email')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}"/>
                        <div id="passwordHelp" class="form-text">Min 6 characters, 1 letter and 1 number</div>
                        @error('password')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" name="role_id" id="role">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
                @if(session('error'))
                    <div class="alert alert-danger p-3">{{session('error')}}</div>
                @endif
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin.js')}}"></script>
@endsection
