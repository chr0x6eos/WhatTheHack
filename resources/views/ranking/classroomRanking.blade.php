@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header font-weight-bold">{{ __('Classroom Ranking') }}</div>
            <div class="card-body">
                <select class="btn btn-outline-dark dropdown-toggle">
                    <option value="-1"> All Classrooms</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
                    @endforeach
                </select><br><br>

                @foreach($classrooms as $classroom)
                <table id="{{ $classroom->id }}" class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td class="font-weight-bold">{{ $classroom->classroom_name }}</td>
                        </tr>
                        <tr>
                            <td>Rank</td>
                            <td>Username</td>
                            <td>Points</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($classroom->getRankedUsers() as $key => $value)
                        @if($value->username == $currentUser->username)
                            <tr bgcolor="#00c800">
                                <td>{{ $key }}</td>
                                <td>{{ $value->username }}</td>
                                <td>{{ $value->points }}</td>
                            </tr>
                        @else
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $value->username }}</td>
                            <td>{{ $value->points }}</td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                @endforeach

                <script>
                    $('select').change(function(){
                        if($(this).val() != "-1")
                        {
                            $('table.table').hide();
                            $('table#'+$(this).val()).show();
                        }
                        else {
                            $('table.table').show();
                        }
                    });
                </script>
            </div>
        </div>
    </div>



@endsection
