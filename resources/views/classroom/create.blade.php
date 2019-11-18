@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Classroom</h2>
        <div class="col-2">
            <form method="post" action="{{route('classroom.store')}}" >
                @csrf
                <p>
                    <strong>Name:</strong>
                    <input type="text" class="form-control" name="name" placeholder="Name">
                </p>

                    <table>
                        <thead>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Add</th>
                        </thead>
                        <tbody>
                        @foreach (\App\User::all() as $u)
                            @if(Auth::user()->isStudent($u->userrole) == true)

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
                    <button type="submit"  class="btn btn-success">
                        Create
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-danger">
                        Cancel
                    </a>
                </p>
            </form>
        </div>
    </div>
@endsection
