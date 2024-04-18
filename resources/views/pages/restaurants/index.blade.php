@extends('layouts.layout')
@section('content')
    <div class="restaurants-div">
        <div class="restaurants-container">
            <div class="restaurants-heading">
                <h2>Restaurants</h2>
            </div>
            <div class="restaurants-content">
                <div class="row restaurants-listing"></div>
                <div class="pagination">
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
@endsection
@section('script')
    <script src="{{asset('assets/js/restaurant.js')}}"></script>
@endsection
