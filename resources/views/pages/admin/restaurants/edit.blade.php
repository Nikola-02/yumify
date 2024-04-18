@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-pages-heading text-center mb-5 mt-1">
            <h1>Restaurant - edit form</h1>
        </div>
        <div class="page-form d-flex justify-content-center mb-5">
            <div class="col-md-5">
                <form action="/admin/restaurants/{{$restaurant->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter new name" id="name" value="{{$restaurant->name}}"/>
                        @error('name')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{$restaurant->description}}</textarea>
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
                        <img class="restaurant-edit-img" src="{{asset('storage/images/'.$restaurant->image)}}" alt="{{$restaurant->name}}" />
                        @error('image')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="Enter location" id="location" value="{{$restaurant->location}}"/>
                        @error('location')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="open_in" class="form-label">Open in</label>
                        <input type="time" name="open_in" class="form-control" id="open_in" value="{{$restaurant->open_in}}"/>
                        @error('open_in')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="close_in" class="form-label">Close in</label>
                        <input type="time" name="close_in" class="form-control" id="close_in" value="{{$restaurant->close_in}}"/>
                        @error('close_in')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="types" class="form-label">Types (select multiple with ctrl)</label>
                        <select multiple class="form-select" name="types[]" id="types">
                            @foreach($types as $type)
                                <option @selected(in_array($type->id, $restaurant->types->pluck('id')->ToArray())) value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        @error('types')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="benefits" class="form-label">Benefits (select multiple with ctrl)</label>
                        <select multiple class="form-select" name="benefits[]" id="benefits">
                            @foreach($benefits as $b)
                                <option @selected(in_array($b->id, $restaurant->benefits->pluck('id')->ToArray())) value="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                        </select>
                        @error('benefits')
                        <div class="alert alert-danger p-3 mt-2">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

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
