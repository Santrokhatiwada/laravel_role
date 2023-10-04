@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Projects</h2>
                    </div>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('projects.create') }}"> Create New Project </a>




                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif

                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Tasks</th>

                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($projects as $project)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->details }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('projects.tasks.index', ['project' => $project->id]) }}">Show</a>
                                    <a class="btn btn-info" href="{{ route('tasks.create') }}">Create</a>

                                </td>



                                <td>

                                </td>
                            </tr>
                            @endforeach
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection