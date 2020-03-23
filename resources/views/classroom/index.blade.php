@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card" style="overflow: auto;">
            <div class="card-body">
                <h2>All Classrooms:</h2>
                <br>
                @if($classrooms != null && sizeof($classrooms) > 0)
                    <table id="classroom" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>Owner</td>
                            <td>Edit general information</td>
                            <td>Add/delete members</td>
                            <td>Add/delete challenges</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($classrooms as $classroom)
                            @if($classroom->active == "1")
                                <tr>
                                    <td>{{ $classroom->classroom_name }}</td>
                                    <td>{{ \App\User::find($classroom->classroom_owner)->username }}</td>
                                    @if(Auth::user()->hasRole("admin") || $classroom->isOwner(Auth::user()->id))
                                        <td>
                                            <a href="{{ route('classroom.edit', $classroom->id) }}" class="btn bg-light btn-outline-dark">Edit</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('classroom.editMembers', $classroom->id) }}" class="btn bg-light btn-outline-dark">Edit</a>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{ route('classroom.editChallenges', $classroom->id) }}" class="btn bg-light btn-outline-dark">Edit</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="card-text">There are no classrooms yet</p>
                @endif
                @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('admin'))
                    <a href="{{route('classroom.create')}}" class="btn btn-success">Add new classroom</a>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(
            function () {
                $('#classroom').DataTable( {
                    "paging": true,
                    "info":false,
                    "aoColumns": [
                        null,
                        null,
                        { "bSearchable": false, "orderable": false },
                        { "bSearchable": false, "orderable": false },
                        { "bSearchable": false, "orderable": false },
                        // { "bSearchable": false, "orderable": false }
                    ]
                });
                $('.dataTables_length').addClass('bs-select');
            });
    </script>
@endsection
