@extends('layouts.app')

@section('content')
    <h1>Classroom Ranking</h1>
    <select>
        <option value="-1"> Select Classroom</option>
        @foreach($classrooms as $classroom)
            <option value="{{ $classroom->id }}">{{ $classroom->classroom_name }}</option>
        @endforeach
    </select>

    @foreach($classrooms as $classroom)
    <table id="{{ $classroom->id }}" class="table">
        <thead>
            <tr>
                <td>{{ $classroom->classroom_name }}</td>
            </tr>
            <tr>
                <td>Rank</td>
                <td>Username</td>
                <td>Points</td>
            </tr>
        </thead>
        <tbody>
        @foreach($classroom->users as $user)
            <tr>
                <td></td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->points }}</td>
            </tr>
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


@endsection
