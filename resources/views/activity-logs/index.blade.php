@extends('layouts.apps')

@section('content')

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h1>Activity Logs</h1>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Log ID</th>
                                    <th>Description</th>
                                    <th>Causer</th>
                                    <th>Model</th>
                                    <th>Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activityLogs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->causer->name ?? "system" }}</td>
                                
                                    <td>{{$log->subject_type}}</td>
                                    <td>{{ Carbon\Carbon::parse($log->updated_at)->diffForHumans() }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection