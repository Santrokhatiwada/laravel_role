@extends('layouts.apps')

@section('content')
<style>
    .buttons {
        margin-left: 800px;
       margin-top: -50px;
    }
</style>

<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Projects</h2>
                    </div>
                    <div class="pull-right" style="margin-top:5px;">

                        <a class="btn btn-success" href="{{ route('projects.create') }}"> Add New Project </a>




                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif


                        @foreach ($projects as $project)

                        <div class="body flex-grow-1 px-3" style="margin-top:12px;">
                            <div class="container-lg">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 margin-tb">
                                                <div class="form-group">
                                                    <strong>No:</strong>
                                                    {{ ++$i }}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Name: </strong>
                                                    {{ $project->name }}
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Details: </strong>
                                                    {{ $project->details }}
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong> Total Task: </strong>
                                                    {{ $project->projectTasks->count() }}
                                                    <div class="buttons">
                                                        <a class="btn btn-primary" href="{{ route('projects.edit',$project->id) }}">Edit</a>
                                                        <a class="btn btn-danger" href=# onclick="event.preventDefault();document.getElementById('delete-project-form').submit();">Delete</a>
</div>
                                                            <hr>
                                                            <a class="btn btn-info" href="{{ route('projects.tasks.index', ['project' => $project->id]) }}">Show Tasks</a>




                                                        </div>
                                                    </div>


                                                    <form action="{{ route('projects.destroy',$project->id) }}" method="POST" id="delete-project-form">
                                                        @csrf
                                                        @method('DELETE')

                                                    </form>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @endforeach




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection