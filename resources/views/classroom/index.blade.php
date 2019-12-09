@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header font-weight-bold">{{ __('My classrooms') }}</div>

            <div class="card-body">
                @if(sizeof($classrooms) > 0)
                    <table border="1" class="table table-striped table-bordered">
                        <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Owner</th>
                        </thead>
                        <tbody>
                        @foreach($classrooms as $classroom)
                            <tr>
                                <td>{{ $classroom->id }}</td>
                                <td>{{ $classroom->classroom_name }}</td>
                                <td>{{ $classroom->classroom_owner }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <table border="1" class="table table-striped table-bordered">
                        <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Owner</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
                <br>
                @if(Auth::user()->isAdmin(Auth::user()->userrole)==true)
                    <a href="{{route('classroom.create')}}" class="btn btn-info">Add new classroom</a>
                @endif
            </div>
        </div>
    </div>
@endsection
