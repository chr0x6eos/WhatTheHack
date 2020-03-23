@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="card" style="overflow: auto;">
            <div class="card-header font-weight-bold">{{ __('User Management') }}</div>

            <div class="card-body">
                @if (Auth::User()->userrole != 'admin')
                    <div class="container">
                        <div class="alert alert-danger" role="alert">
                            Invalid request. (MU_V_INDEX_PERMISSION_DENIED)
                        </div>
                    </div>
                @elseif ($errors->any())
                    <div class="container">
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @else
                    <div class="container">

                        @if(sizeof($users) > 0)
                            <table id="usertable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead>
                                <th class="th-sm" scope="col">#</th>
                                <th class="th-sm" scope="col">Username</th>
                                <th class="th-sm" scope="col">Role</th>
                                <th class="th-sm" scope="col">E-Mail</th>
                                <th class="th-sm" scope="col">Disable/Enable Account</th>
                                <!-- <th class="th-sm" scope="col">Save</th> -->
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    
                                    @if(!$user->active)
                                    <tr class="disabled-style">
                                    @else
                                    <tr>
                                    @endif
                                        <th scope="row">{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('manageuser.update', $user) }}", id="manageuserform">
                                            @csrf
                                            @method('patch')

                                            <!-- This disallows administrators to revoke the admin rank from other administrators
                                            if($user->userrole == "admin") -->

                                                @if($user == Auth::user())
                                                <select name="userrole" id="userrole" class="form-control" disabled>
                                                @else
                                                <select name="userrole" id="userrole" class="form-control" onchange="this.form.submit()">
                                                @endif
                                                    @if($user->userrole == "student")
                                                    <option value="student" selected>Student</option>
                                                    @else
                                                    <option value="student">Student</option>
                                                    @endif

                                                    @if($user->userrole == "teacher")
                                                    <option value="teacher" selected>Teacher</option>
                                                    @else
                                                    <option value="teacher">Teacher</option>
                                                    @endif

                                                    @if($user->userrole == "admin")
                                                    <option value="admin" selected>Administrator</option>
                                                    @else
                                                    <option value="admin">Administrator</option>
                                                    @endif
                                                </select>

                                                        <input type="hidden" name="type" value="userrole_change">
                                                </select>
                                            </form>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('manageuser.update', $user) }}", id="manageuserform">
                                                @csrf
                                                @method('patch')
                                                @if($user->active)
                                                    @if($user == Auth::user())
                                                    <button class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Deactivate Account" disabled>&#10005;</button>
                                                    @else
                                                    <button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Deactivate Account">&#10005;</button>
                                                    @endif
                                                @else
                                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Activate Account">&#10005;</button>
                                                @endif
                                                <input type="hidden" name="type" value="active_status">
                                            </form>
                                        </td>
                                        <!-- <td>
                                            <button type="submit" class="btn btn-alert">OK</button>
                                        </td> -->
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="container">
                                <div class="alert alert-danger" role="alert">
                                    Found no Users. (MU_V_INDEX_FOUND_NO_USERS)
                                </div>
                            </div>
                        @endif
                        <br>
                    </div>

                    <script>
                        $(document).ready(function () {
                            $('#usertable').DataTable( {
                                "aoColumns": [
                                    null,
                                    null,
                                    { "bSearchable": false, "orderable": false },
                                    null,
                                    { "bSearchable": false, "orderable": false },
                                    // { "bSearchable": false, "orderable": false }
                                ] }
                            );
                        });
                    </script>
                <!-- <a href="{{route('challenges.create')}}" class="btn btn-success">Add new challenge</a> -->
                @endif
            </div>
        </div>
    </div>
@endsection
