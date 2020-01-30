@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>You are in this classroom: {{$classroom->classroom_name}}</h1>
        @if($classroom->isOwner(Auth::user()->id) || Auth::user()->hasRole('admin'))
          <h3>Add challenges</h3>
        @endif
        <div>
            @if($classroom->isOwner(Auth::user()->id) || Auth::user()->hasRole('admin'))
               <form method="post" action="{{ route('classroom.attach', $classroom->id)}}" >
                @csrf

                <table id="challenges" border="1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <th class="th-sm">Challenge id</th>
                    <th class="th-sm">Challenge name</th>
                    <th class="th-sm">Challenge difficulty</th>
                    <th class="th-sm">Challenge description</th>
                    <th class="th-sm">Challenge category</th>
                    <th>Add</th>
                    </thead>
                    <tbody>
                    @foreach (\App\Challenge::all() as $c)
                        @if(!$classroom->getClassroomChallenges($c->id) && $c->active==true)
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
                                <input type="checkbox" name="add_Challenges[]" value="{{$c->id}}">
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

                <br>
                <p>
                    <button type="submit"  class="btn btn-success">
                        Submit
                    </button>
                    <a href="{{ route('classroom.myClassrooms')}}" class="btn btn-danger">
                        Cancel
                    </a>
                </p>
               </form>
            @endif
        </div>

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
                    @if($classroom->isOwner(Auth::user()->id) ||Auth::user()->hasRole('admin'))
                        <th>Remove</th>
                    @endif
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
                            @if($classroom->isOwner(Auth::user()->id)||Auth::user()->hasRole('admin'))
                                <td>
                                    <input type="checkbox" name="remove_Challenges[]" value="{{$c->id}}">
                                </td>
                            @endif
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
                @if($classroom->isOwner(Auth::user()->id)||Auth::user()->hasRole('admin'))
                <p>

                    <button type="submit"  class="btn btn-success">
                        Submit
                    </button>
                    <a href="{{ route('classroom.myClassrooms') }}" class="btn btn-danger">
                        Cancel
                    </a>
                </p>
                    @endif
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


