@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Edit Task</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back </a>
                    </div>

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


                    <form action="{{ route('tasks.update',$task->id) }}" method="POST">

                        @csrf
                        @method('PATCH')


                        <div class="row">
                            @role('SuperAdmin')
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Task Name:</strong>
                                    <input type="text" name="task_name" class="form-control" value="{{ $task->task_name }}" placeholder="Task Name">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Task Description:
                                        </strong>
                                        <textarea class="form-control" style="height:150px" value="{{ $task->description }}" name="description" placeholder="Task Description"></textarea>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="deadline">Deadline:</label>
                                            <input type="datetime-local" name="deadline" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="assigner_select1">Assigned to:</label>
                                            <select name="user_id" class="form-control">
                                                <option disabled selected>Select to Assign Task</option>

                                                @foreach($user as $user)


                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="assigner_select">Assigned by:</label>
                                            <select name="assigner_id" class="form-control" disabled>
                                                <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        @endrole
   
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="new_status">Status</label>
                                                @role('User')

                                                <input type="text" class="user_id" name="user_id" value={{Auth::id()}} readonly>{{Auth::user()->name}}
                                              
                                                @endrole
                                                <select name="new_status" id="new_status" class="form-control">
                                                    <option value="" disabled selected>Status</option>
                                                    @role('User')
                                                    <option value="pending" disabled selected>Pending</option>
                                                    <option value="on-progress">On Progress</option>
                                                    <option value="completed">Completed</option>
                                                    @endrole
                                                    @role('SuperAdmin')
                                                    <option value="accepted">Accepted</option>
                                                    <option value="rejected">Rejected</option>
                                                    @endrole
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