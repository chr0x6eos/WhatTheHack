@extends('layouts.app')
@section('content')
    <div id="landing" class="py-5">
        <div data-test="container" class="container">
            <div data-test="row" class="row">
                <div data-test="col" class="col-lg-9">
                    <div data-test="card" class="card text-dark">
                        <div data-test="card" class="card-body">
                            <h2>My Classrooms</h2>
                            <div class="text-center p-5">
                                @if($classrooms != null && sizeof($classrooms) > 0)
                                    <table id="classroom" class="table table-striped table-bordered">
                                        <thead>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Owner</th>
                                        @if(Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher"))
                                            <th>Info</th>
                                            <th>Members</th>
                                        @endif
                                        <th>Challenges</th>
                                        </thead>
                                        <tbody>
                                        @foreach($classrooms as $classroom)
                                            @if($classroom->active == "1")
                                                <tr>
                                                    <td>{{ $classroom->id }}</td>
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
                                                        <a href="{{ route('classroom.showChallenges', $classroom->id) }}" class="btn bg-light btn-outline-dark">Show challenges</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h3>No classrooms yet!</h3>
                                @endif
                                <br>
                                @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('admin'))
                                    <a href="{{route('classroom.create')}}" class="btn btn-success">Add new classroom</a>
                                @endif
                                <mdb-icon fab icon="facebook-f"></mdb-icon>

                                <script>
                                    $(document).ready(
                                        function () {
                                            $('#classroom').DataTable( {
                                                "paging": true,
                                                "info":false,
                                                "aoColumns": [
                                                    null,
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
