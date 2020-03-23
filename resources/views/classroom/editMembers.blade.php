@extends('layouts.app')
@section('content')
<div id="landing" class="py-5">
    <div data-test="container" class="container">
        <div data-test="row" class="row">
            <div data-test="col" class="col-md-12 mb7">
                <div class="card card_showChallenge">
                    <div data-test="card" class="card-body">
                        <p class="h2" style="display: inline">Edit the members of the classroom: </p><p class="h2" style="color: #01C851; display: inline"> {{$classroom->classroom_name}}</p>
                        <br>
                        <br>
                        <form method="post" action="{{ route('classroom.updateMembers', $classroom) }}">
                            @csrf
                            <h3>Add members</h3>
                            <table class="table table-striped table-bordered" id="addmembers">
                                <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Add</th>
                                </thead>
                                <tbody>
                                @foreach(\App\User::all() as $u)
                                    @if($u->hasRole("student") && !$classroom->getMembers($u->id) && $u->active)
                                        <tr>
                                            <td>{{ $u->id }}</td>
                                            <td>{{ $u->username }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>
                                                <input type="checkbox" class="col-12" name="addmember[]" value="{{ $u->id }}">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">
                                Add selected
                            </button>
                        </form>
                        <br>
                        <form method="post" action="{{ route('classroom.deleteMembers', $classroom) }}">
                            @csrf
                            @method('patch')
                            <h3>Delete members</h3>
                                <table class="table table-striped table-bordered" id="deletemembers">
                                    <thead>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User-Role</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                        @foreach($classroom->Users as $u)
                                        <tr>
                                            <td>{{ $u->id }}</td>
                                            <td>{{ $u->username }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->userrole }}</td>
                                            <td>
                                                <input type="checkbox" class="col-12" name="deletemembers[]" value="{{ $u->id }}" @if($u->hasRole("admin") || $classroom->isOwner($u->id)) disabled = "disabled" @endif>
                                            </td>
                                        </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-danger">
                                    Remove selected
                                </button>
                                <p>
                                    <a href="{{ route('classroom.myClassrooms') }}" class="btn btn-outline-dark">
                                        Go back
                                    </a>
                                </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(
        function () {
            $('#deletemembers').DataTable( {
                "paging": true,
                "info":false,
                "aoColumns": [
                    null,
                    null,
                    null,
                    { "bSearchable": true, "orderable": false },
                    { "bSearchable": false, "orderable": false },
                    //null,
                    //{ "bSearchable": false, "orderable": false },
                    // { "bSearchable": false, "orderable": false }
                ]
            });
        });

    $(document).ready(
        function () {
            $('#addmembers').DataTable( {
                "paging": true,
                "info":false,
                "aoColumns": [
                    null,
                    null,
                    null,
                    { "bSearchable": false, "orderable": false },
                    // { "bSearchable": false, "orderable": false }
                ]
            });
        });
</script>
@endsection
