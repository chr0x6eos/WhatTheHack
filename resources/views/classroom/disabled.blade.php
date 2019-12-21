@extends('layouts.app')
@section('content')
    <h2>Disabled classrooms</h2>
    <body>

    @if(sizeof($classrooms) > 0)
        <table class="table table-striped table-bordered">
            <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Owner</th>
            <th>Restore</th>
            <th>Delete</th>
            </thead>
            <tbody>
            @foreach($classrooms as $classroom)
                @if($classroom->active == "0")
                    <tr>
                        <td>{{ $classroom->id }}</td>
                        <td>{{ $classroom->classroom_name }}</td>
                        <td>{{ $classroom->classroom_owner }}</td>
                        <td>
                            <form method="post" action="{{ route('classroom.restore', $classroom->id)}}" >
                                @csrf
                                @method('patch')

                                <input type="submit" class="btn btn-success">
                            </form>
                        </td>
                        <td>
                            <form method="post" action="{{ route('classroom.destroy', $classroom->id)}}" >
                                @csrf
                                @method('delete')
                                <input type="submit" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @else
        <h3>No disabled classrooms yet!</h3>
    @endif

    </body>

@endsection
