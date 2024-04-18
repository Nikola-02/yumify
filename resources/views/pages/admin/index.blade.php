@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-heading">
            <h1>Dashboard</h1>
        </div>

        <div class="index-heading">
            <h3>Activity log</h3>
        </div>

        <div class="index-pages-table dashboard-report">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Action</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $counter = 0;
                @endphp
                @foreach($log_lines as $line)
                    @php
                    $counter++;
                    $parts = explode(',',$line);
                    list($username, $action, $date) = $parts;
                    @endphp
                    <tr>
                        <th scope="row">{{$counter}}</th>
                        <td>{{$username}}</td>
                        <td>{{$action}}</td>
                        <td>{{$date}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="index-heading mt-5">
            <h3>Errors log</h3>
        </div>

        <div class="index-pages-table dashboard-report mb-5">
            <table class="table table-striped">
                @foreach($error_logs as $log)
                    <tr>
                        <td>{{ $log }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
