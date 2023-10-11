@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Report</h2>
                    </div>

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Project Name</th>
                            <th>Task</th>
                            <th>Assign User</th>
                            <th>Status</th>
                        </tr>
                        @php $i = 0; @endphp
                        @foreach ($reportData as $report)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $report->project_name }}</td>
                            <td>{{ $report->task_name }}</td>
                            <td>{{ $report->user_name }}</td>
                            <td>{{ $report->status_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection