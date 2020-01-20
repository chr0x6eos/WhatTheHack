@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>You are in this classroom: {{$classroom->classroom_name}}</h1>
        @if($classroom->isOwner(Auth::user()->id)||Auth::user()->hasRole('student'))
            <h3>Add challenges</h3>
        @endif


        <div>
            <form method="post" action="{{route('classroom.detach',$classroom->id)}}" >
                @csrf
                {{ method_field("delete") }}
                <h3>This challenges are available</h3>
                <table id="challenges2" border="1" class=" table table-striped table-bordered">
                    <thead>
                    <th>Challenge id</th>
                    <th>Challenge name</th>
                    <th>Challenge difficulty</th>
                    <th>Challenge description</th>
                    <th>Challenge category</th>
                    <th class="th-sm">Challenge Details</th>
                    </thead>
                    <tbody>
                    @foreach ($classroom->challenges as $c)
                        <tr>
                            <td>
                                {{$c->id}}
                            </td>
                            <td>
                                {{$c->name}}
                            </td>
                            <td>
                                {{$c->difficulty}}
                            </td>
                            <td>
                                {{$c->description}}
                            </td>
                            <td>
                                {{$c->category}}
                            </td>
                            <td>
                                <a href="{{route('challenges.show',$c->id)}}" class="button badge-info">Details</a>
                            </td>
                        </tr>
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
                <br>
                <br>

            </form>
        </div>
    </div>

    <script>
        $(document).ready(
            function () {
                $('#challenges').DataTable( {
                    "paging": true,
                    "info":false,
                    "aoColumns": [
                        null,
                        null,
                        { "bSearchable": true, "orderable": false },
                        { "bSearchable": false, "orderable": false },
                        null,
                        { "bSearchable": false, "orderable": false },
                        // { "bSearchable": false, "orderable": false }
                    ]
                });
            });

        $(document).ready(
            function () {
                $('#challenges2').DataTable( {
                    "paging": true,
                    "info":false,
                    "aoColumns": [
                        null,
                        null,
                        { "bSearchable": true, "orderable": false },
                        { "bSearchable": false, "orderable": false },
                        null,
                        { "bSearchable": false, "orderable": false },
                        // { "bSearchable": false, "orderable": false }
                    ]
                });
            });
    </script>
@endsection


