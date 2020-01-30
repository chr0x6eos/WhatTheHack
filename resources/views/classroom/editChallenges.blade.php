@extends('layouts.app')
@section('content')
<div id="landing" class="py-5">
    <div data-test="container" class="container">
        <div data-test="row" class="row">
            <div data-test="col" class="col-md-12 mb7">
                <div class="card card_showChallenge">
                    <div data-test="card" class="card-body">
                        <p class="h2" style="display: inline">Edit the challenges for the classroom </p><p class="h2" style="color: #01C851; display: inline">{{$classroom->classroom_name}}</p>
                        <br>
                        <br>
                        @if($classroom->isOwner(Auth::user()->id) || Auth::user()->hasRole('admin'))
                            <h3>Add challenges to the classroom</h3>
                            <form method="post" action="{{ route('classroom.attach', $classroom->id)}}" >
                                @csrf
                                <table id="challenges" border="1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <th class="th-sm">Challenge id</th>
                                        <th class="th-sm">Challenge name</th>
                                        <th class="th-sm">Challenge difficulty</th>
                                        <th class="th-sm">Status</th> {{-- //TODO: SHOULD STATUS BE SHOWN INSTEAD OF DESCRIPTION? DESCRIPTION IS REALLY LONG... --}}
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
                                                    @if($c->active)Active @else Retired @endif
                                                </td>
                                                <td>
                                                    {{$c->category}}
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="col-12" name="add_Challenges[]" value="{{$c->id}}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <p>
                                    <button type="submit" class="btn btn-success">
                                        Add selected
                                    </button>
                                    <a href="{{ route('classroom.myClassrooms')}}" class="btn btn-danger">
                                        Cancel
                                    </a>
                                </p>
                            </form>

                            <form method="post" action="{{route('classroom.detach',$classroom->id)}}" >
                                @csrf
                                {{ method_field("delete") }}
                                <h3>Remove challenges from the classroom</h3>
                                <table id="challenges2" border="1" class=" table table-striped table-bordered">
                                    <thead>
                                        <th>Challenge id</th>
                                        <th>Challenge name</th>
                                        <th>Challenge difficulty</th>
                                        <th>Status</th>
                                        <th>Challenge category</th>
                                        <th class="th-sm">Challenge Details</th>
                                        <th>Remove</th>
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
                                                @if($c->active)Active @else Retired @endif
                                            </td>
                                            <td>
                                                {{$c->category}}
                                            </td>
                                            <td>
                                                <a href="{{route('challenges.show',$c->id)}}" class="button btn-outline-light-blue btn-toolbar">Details</a>
                                            </td>
                                            @if($classroom->isOwner(Auth::user()->id)||Auth::user()->hasRole('admin'))
                                                <td>
                                                    <input type="checkbox" class="col-12" name="remove_Challenges[]" value="{{$c->id}}">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <p>

                                    <button type="submit"  class="btn btn-success">
                                        Remove selected
                                    </button>
                                    <a href="{{ route('classroom.myClassrooms') }}" class="btn btn-danger">
                                        Cancel
                                    </a>
                                </p>
                            </form>
                    @endif
                    </div>
                </div>
            </div>
        </div>
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


