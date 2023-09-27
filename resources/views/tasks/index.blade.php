@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Task Management System</h2>
                    </div>
                    <div class="pull-right">
                        @can('task-create')
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create Task </a>
                        </div>
                        @endcan

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif








                       



                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Task Name</th>
                                <th>Description</th>
                                <th>Deadline:</th>
                                <th>Assign-to</th>
                                @role('SuperAdmin')
                                <th>Assigned by</th>
                                @endrole
                                <th>status</th>
                                <th width="280px">Action</th>
                            </tr>
                            <?php $i = 0; ?>
                            @foreach ($tasks as $task)
                           
                            @if(Auth::user()->hasRole('SuperAdmin') || (Auth::user()->hasRole('User') && optional($task->taskUser)->id === Auth::id()))
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$task->task_name}}</td>
                                <td>{{$task->description}}</td>

                                <td>
                                    @if(isset($task->deadline))
                                    {{$task->deadline}} <br>
                                    {{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                                    @else
                                    <p>Not Mentioned</p>
                                    @endif

                                </td>
                                <td>
                                    @if(isset($task->taskUser))
                                    {{$task->taskUser->name}}
                                    @else
                                    <p>Not Assigned!</p>
                                    @endif
                                </td>
                                @role('SuperAdmin')
                                <td>{{Auth::user()->name}}</td>
                                @endrole

                                <td>{{$task->statuses->last()->name ?? 'No Status'}}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('tasks.show',$task->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('tasks.edit',$task->id) }}">Edit</a>
                                    @can('task-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['tasks.destroy', $task->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


