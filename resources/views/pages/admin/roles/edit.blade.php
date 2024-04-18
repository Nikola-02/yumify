@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-pages-heading text-center mb-5 mt-1">
            <h1>Role - edit form</h1>
        </div>
        <div class="page-form d-flex justify-content-center">
            <div class="col-md-5">
                <form action="/admin/roles/{{$role->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="role_name" value="{{$role->name}}"/>
                    </div>
                    @error('name')
                    <div class="alert alert-danger p-3">
                        {{$message}}
                    </div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Edit</button>
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
