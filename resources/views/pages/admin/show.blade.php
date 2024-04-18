@extends('layouts.admin_layout')
@section('content')
    <div class="index-admin-page">
        <div class="index-pages-heading">
            <h1>{{ucfirst($table_name)}}</h1>
        </div>

        <div class="index-pages-table">
            @if($table_name != 'ratings')
            <div class="create-new-btn">
                <a href="/admin/{{$table_name}}/create">Create new</a>
            </div>
            @endif
            <div class="data-table">
                @if(count($table_data) > 0)
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            @foreach($column_names as $col)
                                @if($col != 'id')
                                    <th scope="col">{{$col}}</th>
                                @endif
                            @endforeach
                            @if($table_name != 'ratings')
                                <th scope="col">Edit</th>
                            @endif
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($table_data as $key=>$row)
                            <tr>
                                <td>{{$key + 1}}</td>
                                @foreach($column_names as $col)
                                    @if($col != 'id')
                                        @if($col == 'price')
                                            <td>${{is_array($row) ? $row[$col] : $row->$col}}</td>
                                        @elseif($col == 'image')
                                            <td><img src="{{asset('/storage/images/'.(is_array($row) ? $row[$col] : $row->$col))}}" alt="{{is_array($row) ? $row['name'] : $row->name}}"></td>
                                        @else
                                            <td>{{is_array($row) ? $row[$col] : $row->$col}}</td>
                                        @endif
                                    @endif
                                @endforeach
                                @if($table_name != 'ratings')
                                    <td><a class="btn btn-primary d-flex justify-content-center align-items-center" href="/admin/{{$table_name}}/{{is_array($row) ? $row['id'] : $row->id}}/edit"><i class='bx bxs-edit'></i></a></td>
                                @endif
                                <td><a class="btn btn-danger d-flex justify-content-center align-items-center delete-btn" data-table="{{$table_name}}" data-id="{{is_array($row) ? $row['id'] : $row->id}}"><i class='bx bx-x-circle'></i></a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                @else
                    <div class="alert alert-danger p-4">No rows for this table.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="btn btn-alert notification-admin-error d-none"></div>
    <div class="btn btn-success notification-admin-success-delete d-none"></div>
    @if (session('message'))
        <div class="notification">
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-200" class="alert alert-success" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0">{{ session('message') }}</p>
                    <button @click="show = false" class="close btn" type="button">
                        <i class="fa-solid fa-xmark "></i>
                    </button>
                </div>
            </div>

        </div>
    @endif
@endsection
@section('script')
    <script src="{{asset('assets/js/admin.js')}}"></script>
@endsection
