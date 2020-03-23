@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <h2>Create new Classroom:</h2>
                <br>
                <form method="post" action="{{route('classroom.store')}}" >
                    @csrf
                    <p>
                        <strong>Name:</strong>
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </p>

                    <table id="student" class="table table-striped table-bordered">
                        <thead>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Add</th>
                        </thead>
                        <tbody>
                        @foreach (\App\User::all() as $u)
                            @if($u->hasRole("student"))
                                <tr>
                                    <td>
                                        {{$u->username}}
                                    </td>
                                    <td>
                                        {{$u->email}}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="add_Students[]" value="{{$u->getAuthIdentifier()}}">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled"   >
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p>
                        <button type="submit"  class="btn btn-info">
                            Create
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-danger">
                            Cancel
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(
            function () {
                $('#student').DataTable( {
                    "paging": true,
                    "info":false,
                    "aoColumns": [
                        null,
                        null,
                        { "bSearchable": false, "orderable": false },
                        // { "bSearchable": false, "orderable": false }
                    ]
                });
            });
    </script>
@endsection
