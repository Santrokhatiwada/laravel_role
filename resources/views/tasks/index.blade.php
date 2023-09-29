@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">

                    </div>
                    <div class="pull-right">
                        @can('task-create')
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create Task </a>
                        </div>
                        @endcan




                        <head>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <title>Task management</title>
                            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                            <style>
                                #draggable {
                                    width: 150px;
                                    height: 150px;
                                    padding: 0.5em;
                                }
                            </style>
                        </head>

                        <body class="bg-light">
                            <div class="container">

                                <div class="col-md-12">
                                    <h2 class="text-center pb-3 pt-1">Task Management</h2>
                                    <div class="row ">
                                        <div class="d-flex overflow-scroll">
                                            <div class="col-md-3 ">
                                                <div class="card">

                                                    <div class="card-header bg-secondary text-white">
                                                        <h1>To Do</h1>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group connectedSortable shadow-lg" id="pending-item-drop">



                                                            @foreach($tasks as $task)
                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='pending')

                                                            <li class="list-group-item" task-id="{{ $task->id }}">{{ $task->task_name }}</li>
                                                            @else
                                                            @endif
                                                            @endif
                                                            @endforeach




                                                           
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 ">
                                                <div class="card">
                                                    <div class="card-header bg-primary text-white">

                                                        <h2>On-Progress</h2>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group connectedSortable shadow-lg" id="on-progress-item-drop">
                                                           
                                                        @foreach($tasks as $task)
                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='on-progress')

                                                            <li class="list-group-item" task-id="{{ $task->id }}">{{ $task->task_name }}</li>
                                                            @else
                                                            @endif
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Additional Cards -->

                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header bg-info text-white">
                                                        <h1>Review</h1>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group  connectedSortable" id="completed-item-drop">
                                                           
                                                        @foreach($tasks as $task)
                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='completed')

                                                            <li class="list-group-item" task-id="{{ $task->id }}">{{ $task->task_name }}</li>
                                                            @else
                                                            @endif
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="card">
                                                    <div class="card-header bg-success text-white">
                                                        <h1>Done</h1>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group  connectedSortable" id="accepted-item-drop">
                                                          
                                                        @foreach($tasks as $task)
                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='accepted')

                                                            <li class="list-group-item" task-id="{{ $task->id }}">{{ $task->task_name }}</li>
                                                            @else
                                                            @endif
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </body>


                    </div>


                </div>

            </div>




        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $("#pending-item-drop,#on-progress-item-drop ,#completed-item-drop ,#accepted-item-drop").sortable({
            connectWith: ".connectedSortable",
            opacity: 0.5,
        });
        $(".connectedSortable").on("sortupdate", function(event, ui) {
            var pending = [];
            var progress=[];
            var completed=[];
            var accepted = [];
            $("#pending-item-drop li").each(function(index) {
                if ($(this).attr('item-id')) {
                    // console.log('drag from');
                    pending[index] = $(this).attr('task-id');
                }
            });
            $("#on-progress-item-drop li").each(function(index) {
                accept[index] = $(this).attr('task-id');
                // console.log('ffsssf');

            });
            $("#completed-item-drop li").each(function(index) {
                progress[index] = $(this).attr('task-id');
                // console.log('ffsssf');

            });

            $("#accepted-item-drop li").each(function(index) {
                accepted[index] = $(this).attr('task-id');
                // console.log('ffsssf');

            });


            $.ajax({

                url: "{{ route('tasks.update',21) }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    pending: pending,
                    accept: accept
                },
                success: function(data) {
                    console.log('success');
                }

            });

        });
    });
</script>












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