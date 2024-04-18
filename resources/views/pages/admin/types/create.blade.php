@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-pages-heading text-center mb-5 mt-1">
            <h1>Type - create form</h1>
        </div>
        <div class="page-form d-flex justify-content-center">
            <div class="col-md-5">
                <form action="/admin/types" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="type_name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="New type name" id="type_name" value="{{old('name')}}"/>
                    </div>
                    @error('name')
                    <div class="alert alert-danger p-3">
                        {{$message}}
                    </div>
                    @enderror
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
