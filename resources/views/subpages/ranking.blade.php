@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header font-weight-bold">{{ __('Ranking') }}</div>

            <div class="card-body">
                <table id="rankingTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Username</th>
                        <th class="th-sm">Overall Points</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sorted as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->overallPoints }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <script>
                    $(document).ready(function () {
                        $('#rankingTable').DataTable();
                        $('.dataTables_length').addClass('bs-select');
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
