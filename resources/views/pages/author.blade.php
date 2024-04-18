@extends('layouts.layout')
@section('content')
    <div class="container author-container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4">
                <img src="{{asset('assets/images/author.png')}}" alt="Author of this website">
            </div>
            <div class="col-md-5">
                <p>Ime i prezime: <strong>Nikola Đunisić</strong></p>
                <p>Broj indeksa: <strong>15/21</strong></p>
                <p>Trenutno pohađa: <strong>Visoku ICT školu</strong></p>
            </div>
        </div>
    </div>
@endsection
