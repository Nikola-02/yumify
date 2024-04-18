@extends('layouts.layout')
@section('content')
    <div class="menu-div">
        <div class="menu-container">
            <div class="menu-heading">
                <h2>{{$restaurant->name}}'s menu</h2>
            </div>
            <div class="row justify-content-end search-sort-row">
                <div class="col-md-12">
                    <div class="search-sort d-flex justify-content-between">
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" id="search-meals" class="form-control" placeholder="Search by name..." aria-label="search" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="sort-meals" class="form-select">
                                <option value="0">Sort by</option>
                                <option value="price-asc">Price asc</option>
                                <option value="price-desc">Price desc</option>
                                <option value="name-asc">Name asc</option>
                                <option value="name-desc">Name desc</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="menu-content d-flex mt-5">
                <div class="col-md-3">
                    <div class="filters">
                        <div class="food-type">
                            <h5>Food type</h5>
                            <form>
                                @foreach($types as $type)
                                    <div class="mb-2 form-check">
                                        <input type="checkbox" class="form-check-input food-type-ch" value="{{$type->id}}" id="type-{{$type->id}}">
                                        <label class="form-check-label" for="type-{{$type->id}}">{{$type->name}}</label>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 menu-items-pagination">
                    {{-- Meals --}}
                    <div class="row menu-items"></div>
                    {{-- Pagination --}}
                    <div class="pagination pagination-menu-meals">
                        <div class="page-info">
                            <p class="m-0 paginate-pages"></p>
                        </div>
                        <nav>
                            <ul>
                                <li class="page-item disabled">
                                    <a class="page-link prev-page">Previous</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link next-page">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-danger notification-meals-menu d-none"></div>

    {{--  Notification  --}}
    <div class="alert alert-success notification-added-to-cart d-none"></div>
@endsection
@section('script')
    <script src="{{asset('assets/js/restaurant-menu.js')}}"></script>
@endsection
