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
                        <!-- @can('role-create') -->
                        <a class="btn btn-success" href="{{route('tasks.create')}}"> Create New Task </a>
                        <!-- @endcan -->


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
                                <th>Assign-to</th>
                                <th>Assgned by</th>
                                <th>status</th>

                             
                                <th width="280px">Action</th>
                            </tr>
                            <?php $i=0;?>
                            @foreach ($tasks as $task)
                        
                            <tr>
                        
                                <td>{{++$i}}</td>
                                <td>{{$task->task_name}}</td>
                                <td>{{$task->description}}</td>
                                <td></td>
                                <td>{{Auth::user()->name}}</td>
                                <td>{{$task->status}}</td>
                                <td>
                                    <a class="btn btn-info" href="#">Show</a>
                                  
                                    <a class="btn btn-primary" href="#">Edit</a>
                                
                                   
                                    {!! Form::open(['method' => 'DELETE','style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    
                                  
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