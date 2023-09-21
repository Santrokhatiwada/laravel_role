@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Add New Task</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back </a>


                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Something went wrong.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Task Name:</strong>
                                        <input type="text" name="task_name" class="form-control" placeholder="Task Name">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Task Description:</strong>
                                            <textarea class="form-control" style="height:150px" name="description" placeholder="Task Description"></textarea>
                                        </div>
                                       
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="assigner_select">Assigned by:</label>
                                                <select name="assigner_id" class="form-control">
                                                    <option value="" disabled selected>Select Assigner</option>
                                                    @foreach ($user as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection