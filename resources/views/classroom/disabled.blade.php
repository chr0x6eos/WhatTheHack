@extends('layouts.app')
@section('content')
<div id="landing" class="py-5">
    <div data-test="container" class="container">
        <div data-test="row" class="row">
            <div data-test="col" class="col-md-12 mb7">
                <div class="card card_showChallenge">
                    <div data-test="card" class="card-body">
                        <h2>Disabled classrooms</h2>
                        @if(isset($classrooms) && sizeof($classrooms) > 0)
                            <table id="classroom" class="table table-striped table-bordered">
                                <thead>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Restore</th>
                                    <th>Delete</th>
                                </thead>
                                <tbody>
                                @foreach($classrooms as $classroom)
                                    @if(!$classroom->active)
                                        <tr>
                                            <td>{{ $classroom->id }}</td>
                                            <td>{{ $classroom->classroom_name }}</td>
                                            <td>{{ $classroom->classroom_owner }}</td>
                                            <td>
                                                <form method="post" action="{{ route('classroom.restore', $classroom->id)}}" >
                                                    @csrf
                                                    @method('patch')

                                                    <button type="submit" class="btn btn-info">Restore</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post" action="{{ route('classroom.destroy', $classroom->id)}}" >
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h3>No disabled classrooms yet!</h3>
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
            $('#classroom').DataTable( {
                "paging": true,
                "info":false,
                "aoColumns": [
                    null,
                    null,
                    null,
                    { "bSearchable": false, "orderable": false },
                    { "bSearchable": false, "orderable": false },
                    { "bSearchable": false, "orderable": false },
                    // { "bSearchable": false, "orderable": false }
                ]
            });
        });
</script>
@endsection
