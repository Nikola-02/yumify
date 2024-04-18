@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-pages-heading text-center mb-5 mt-1">
            <h1>Meal - create form</h1>
        </div>
        <div class="page-form d-flex justify-content-center">
            <div class="col-md-5">
                <form action="/admin/meals" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter new name" id="name" value="{{old('name')}}"/>
                        @error('name')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{old('description')}}</textarea>
                        @error('description')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" id="image" />
                        <div id="imageHelp" class="form-text">Image types: jpg, png</div>
                        @error('image')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="restaurant" class="form-label">Restaurant</label>
                        <select class="form-select" name="restaurant_id" id="restaurant">
                            @foreach($restaurants as $r)
                                <option value="{{$r->id}}">{{$r->name}}</option>
                            @endforeach
                        </select>
                        @error('restaurant_id')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type_id" id="type">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter meal price" id="price" value="{{old('price')}}"/>
                        <div id="priceHelp" class="form-text">Price with two decimal places</div>
                        @error('price')
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
