@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-2">
            <form method="post" action="{{ route('classroom.deleteMembers', $classroom) }}">
                @csrf
                @method('patch')
                <h3>Delete members</h3>
                <p>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Userrole</th>
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
                                    <input type="checkbox" name="deletemembers[]" value="{{ $u->id }}" @if($u->userrole=="admin" || $u->userrole=="teacher") disabled="disabled" @endif>
                                </td>
                            </tr>
                                @endforeach
                        </tbody>
                    </table>
                <button type="submit"  class="btn btn-danger">
                    Delete members
                </button>
            </form>
            <form method="post" action="{{ route('classroom.updatemembers', $classroom) }}">
                @csrf

                </p>
                <h3>Add members</h3>
                <p>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Add</th>
                    </thead>
                    <tbody>
                    @foreach(\App\User::all() as $u)
                        @if($u->userrole == "student" && !$classroom->getMembers($u->id))
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->username }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <input type="checkbox" name="addmember[]" value="{{ $u->id }}">
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                    </table>
            <br>
            <button type="submit"  class="btn btn-success">
                Add members
            </button>
                </p>


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
                    <a href="{{ route('classroom.myclassrooms') }}" class="btn btn-danger">
                        Cancel
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
