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

                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back </a>
                            </div>
                            <div style="margin-top: 10px;">


                                @if($project)


                                <a class="btn btn-success" href="{{ route('projects.tasks.create', ['project' => $project->id]) }}"> Add Task for Project ({{ $project->name }}) </a>
                                @endif
                            </div>

                        </div>
                        @endcan




                        <head>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <title>Task management</title>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                            <style>
                                #draggable {
                                    width: 150px;
                                    height: 150px;
                                    padding: 0.5em;
                                }

                                #eye {
                                    margin-left: 5px;
                                }

                                #priority {
                                    margin-left: 40px;
                                }



                                .circle {
                                    display: inline-block;
                                    background-color: black;

                                    border-radius: 50%;
                                   
                                }

                                .circle-inner {
                                    color: white;
                                    display: table-cell;
                                    vertical-align: middle;
                                    text-align: center;
                                    text-decoration: none;
                                    height: 60px;
                                    width: 60px;
                                    font-size: 30px;
                                }

                                .col-md-3 {
                                    display: grid;
                                }
                            </style>
                        </head>

                        <body class="bg-light">


                            <div class="container">

                                <div class="col-md-12">
                                    <h2 class="text-center pb-3 pt-1">Task Management</h2>

                                    <!-- @foreach($tasks as $task)
                                    @if(isset($project->projectTasks->taskUser))

                                    @foreach($users as $user)
                                   
                                    @if($user->userTask->count() > 0)
                                    
                                    <a href="javascript:void(0);" class="user-image" data-user-name="{{ $user->name}}" data-user-id="{{ $user->id }}">
                                        @if(!empty($user->image))
                                        <div class="circle">
                                            <img height="80px" class="rounded-circle shadow-4-strong circle-inner " alt="avatar2" src="{{ asset('uploads/usersImage/' . $user->image) }}">
                                        </div>
                                        @else
                                        No photo
                                        <div class="circle">
                                            <p class="circle-inner">{{ substr($user->name, 0, 1) }}{{ substr($user->name, strpos($user->name, ' ') + 1, 1) }}</p>
                                        </div>
                                        @endif
                                    </a>
                                    @endif
                                    @endforeach
@else

                                    @foreach($users as $user)
                                   
                                    @if($user->userTask->count() > 0)
                                
                                    <a href="javascript:void(0);" class="user-image" data-user-name="{{ $user->name}}" data-user-id="{{ $user->id }}">
                                        @if(!empty($user->image))
                                        <div class="circle">
                                            <img height="80px" class="rounded-circle shadow-4-strong circle-inner " alt="avatar2" src="{{ asset('uploads/usersImage/' . $user->image) }}">
                                        </div>
                                        @else
                                        No photo
                                        <div class="circle">
                                            <p class="circle-inner">{{ substr($user->name, 0, 1) }}{{ substr($user->name, strpos($user->name, ' ') + 1, 1) }}</p>
                                        </div>
                                        @endif
                                    </a>
                                    @endif
                                    @endforeach


                                    @endif
                                    @endforeach -->
                                   
                                       
                                            @foreach ($uniqueUsers as $user)
                                          
                                                <a href="javascript:void(0);" class="user-image" data-user-name="{{ $user['name'] }}" data-user-id="{{ $user['id'] }}">
                                                    @if (!empty($user['image']))
                                                    <div class="circle">
                                                        <img height="80px" class="rounded-circle shadow-4-strong circle-inner" alt="avatar2" src="{{ asset('uploads/usersImage/' . $user['image']) }}">
                                                    </div>
                                                    @else
                                                    <!-- No photo -->
                                                    <div class="circle">
                                                        <p class="circle-inner circle">{{ substr($user['name'], 0, 1) }}{{ substr($user['name'], strpos($user['name'], ' ') + 1, 1) }}</p>
                                                    </div>
                                                    @endif
                                                </a>
                                          
                                            @endforeach
                                        
                                
                            
                                  



                                    <div class="row ">
                                        <div class="d-flex overflow-scroll">
                                            <div class="col-md-3 ">
                                                <div class="card">

                                                    <div class="card-header bg-secondary text-white">
                                                        <h1>To Do</h1>
                                                    </div>
                                                    <div class="card-body empty-list" data-status="pending">
                                                        <ul class="list-group connectedSortable shadow-lg" id="pending-item-drop">




                                                            @foreach($tasks as $task)
                                                            @if(Auth::user()->hasRole('SuperAdmin') || (Auth::user()->hasRole('User') && optional($task->taskUser)->id === Auth::id() ))


                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='pending')



                                                            <li class="list-group-item" task-id="{{ $task->id }}" onclick="onTaskNameClick('{{ $task->id }}')">{{ $task->task_name }}

                                                                @if ($task->priority === 'high-priority')
                                                                <i id="priority" class="fa-solid fa-h" style="color: #ff2600;"></i>
                                                                @elseif ($task->priority === 'medium-priority')
                                                                <i id="priority" class="fa-solid fa-m" style="color: #0056d6;"></i>
                                                                @elseif ($task->priority === 'low-priority')
                                                                <i id="priority" class="fa-solid fa-l" style="color: #d4e3fe;"></i>
                                                                @endif


                                                                <a href="{{ route('tasks.show', $task->id) }}">
                                                                    <i id="eye" class="fa-solid fa-eye" style="color: #00a3d7;"></i>
                                                                </a>
                                                                @can('task-edit')
                                                                @include('tasks.threedot')
                                                                @endcan





                                                            </li>
                                                            @else
                                                            @endif
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
                                                    <div class="card-body empty-list" data-status="on-progress">
                                                        <ul class="list-group connectedSortable shadow-lg" id="on-progress-item-drop">

                                                            @foreach($tasks as $task)
                                                            @if(Auth::user()->hasRole('SuperAdmin') || (Auth::user()->hasRole('User') && optional($task->taskUser)->id === Auth::id()))

                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='on-progress')

                                                            <li class="list-group-item" task-id="{{ $task->id }}" onclick="onTaskNameClick('{{ $task->id }}')">{{ $task->task_name }}

                                                                @if ($task->priority === 'high-priority')
                                                                <i id="priority" class="fa-solid fa-h" style="color: #ff2600;"></i>
                                                                @elseif ($task->priority === 'medium-priority')
                                                                <i id="priority" class="fa-solid fa-m" style="color: #0056d6;"></i>
                                                                @elseif ($task->priority === 'low-priority')
                                                                <i id="priority" class="fa-solid fa-l" style="color: #d4e3fe;"></i>
                                                                @endif

                                                                <a href="{{ route('tasks.show', $task->id) }}">
                                                                    <i id="eye" class="fa-solid fa-eye" style="color: #00a3d7;"></i>
                                                                </a>
                                                                @can('task-edit')
                                                                @include('tasks.threedot')
                                                                @endcan
                                                            </li>



                                                            @else
                                                            @endif
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
                                                    <div class="card-body empty-list" data-status="completed">
                                                        <ul class="list-group  connectedSortable" id="completed-item-drop">

                                                            @foreach($tasks as $task)
                                                            @if(Auth::user()->hasRole('SuperAdmin') || (Auth::user()->hasRole('User') && optional($task->taskUser)->id === Auth::id()))

                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='completed')

                                                            <li class="list-group-item" task-id="{{ $task->id }}" onclick="onTaskNameClick('{{ $task->id }}')">{{ $task->task_name }}

                                                                @if ($task->priority === 'high-priority')
                                                                <i id="priority" class="fa-solid fa-h" style="color: #ff2600;"></i>
                                                                @elseif ($task->priority === 'medium-priority')
                                                                <i id="priority" class="fa-solid fa-m" style="color: #0056d6;"></i>
                                                                @elseif ($task->priority === 'low-priority')
                                                                <i id="priority" class="fa-solid fa-l" style="color: #d4e3fe;"></i>
                                                                @endif

                                                                <a href="{{ route('tasks.show', $task->id) }}">
                                                                    <i id="eye" class="fa-solid fa-eye" style="color: #00a3d7;"></i>
                                                                </a>
                                                                @can('task-edit')
                                                                @include('tasks.threedot')
                                                                @endcan
                                                            </li>
                                                            @else
                                                            @endif
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
                                                    <div class="card-body empty-list" data-status="accepted">
                                                        <ul class="list-group  connectedSortable" id="accepted-item-drop">

                                                            @foreach($tasks as $task)
                                                            @if(Auth::user()->hasRole('SuperAdmin') || (Auth::user()->hasRole('User') && optional($task->taskUser)->id === Auth::id()))

                                                            @if($task->statuses->isNotEmpty())

                                                            @if($task->statuses->last()->name=='accepted')

                                                            <li class="list-group-item" task-id="{{ $task->id }}" onclick="onTaskNameClick('{{ $task->id }}')">{{ $task->task_name }}


                                                                @if ($task->priority === 'high-priority')
                                                                <i id="priority" class="fa-solid fa-h" style="color: #ff2600;"></i>
                                                                @elseif ($task->priority === 'medium-priority')
                                                                <i id="priority" class="fa-solid fa-m" style="color: #0056d6;"></i>
                                                                @elseif ($task->priority === 'low-priority')
                                                                <i id="priority" class="fa-solid fa-l" style="color: #d4e3fe;"></i>
                                                                @endif

                                                                <a href="{{ route('tasks.show', $task->id) }}">
                                                                    <i id="eye" class="fa-solid fa-eye" style="color: #00a3d7;"></i>
                                                                </a>
                                                                @can('task-edit')
                                                                @include('tasks.threedot')
                                                                @endcan


                                                            </li>
                                                            @else
                                                            @endif
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
<!-- <script>
    function onTaskNameClick(taskId) {
        alert('Task ID: ' + taskId); // You can replace this with your desired action
    }
</script> -->
<script>
    $(function() {
        var newStatus = ""; // Initialize newStatus as an empty string

        // var columnStatusMapping = {
        //     'pending-item-drop': 'pending',
        //     'on-progress-item-drop': 'on-progress',
        //     'completed-item-drop': 'completed',
        //     'accepted-item-drop': 'accepted',


        // };

        var isUserInteraction = true;



        $("#pending-item-drop, #on-progress-item-drop, #completed-item-drop, #accepted-item-drop,.empty-list").sortable({
            connectWith: ".connectedSortable,.card-body",
            opacity: 0.5,
            start: function(event, ui) {
                // Set the flag to true when user interaction starts
                isUserInteraction = true;
            },
            update: function(event, ui) {
                if (isUserInteraction) {
                    var taskId = ui.item.attr("task-id");

                    // var columnId = $("#completed-empty").attr("id");
                    var newStatus = ui.item.closest(".empty-list").data("status");

                    // console.log("Column ID: " + columnId);
                    // var newStatus = columnStatusMapping[columnId];
                    console.log("Task ID: " + taskId);
                    console.log("New Status: " + newStatus);
                    $.ajax({
                        url: "/tasks/" + taskId,
                        method: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: {
                            new_status: newStatus,
                        },
                        success: function(data) {
                            console.log("Task status updated successfully.");
                        },
                        error: function(xhr, status, error) {
                            console.error("Error updating task status: " + error);
                        },
                    });
                }
                // Reset the flag after handling user interaction
                isUserInteraction = true;
            },
            receive: function(event, ui) {
                // Set the flag to false when a task is received from another list
                isUserInteraction = false;
            },

        });



    });
</script>

<!-- for passing user id on click of photo -->
<script>
    function individual_task(task) {
        let priorityIcon = ''; // Initialize an empty string for the priority icon HTML

        // Determine the priority icon based on the task's priority
        if (task.priority === 'high-priority') {
            priorityIcon = '<i id="priority" class="fa-solid fa-h" style="color: #ff2600;"></i>';
        } else if (task.priority === 'medium-priority') {
            priorityIcon = '<i id="priority" class="fa-solid fa-m" style="color: #0056d6;"></i>';
        } else if (task.priority === 'low-priority') {
            priorityIcon = '<i id="priority" class="fa-solid fa-l" style="color: #d4e3fe;"></i>';
        }

        // Construct the individual task item with the priority icon
        return `
    <li class="list-group-item" task-id="${task.id}" onclick="onTaskNameClick('${task.id}')">
        ${task.task_name}
        ${priorityIcon}  <!-- Insert the priority icon here -->
        <a href="/tasks/${task.id}">
            <i id="eye" class="fa-solid fa-eye" style="color: #00a3d7;"></i>
        </a>
        <i id="threeDot" class="fas fa-ellipsis-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
        <ul class="dropdown-menu">
            <li>
                <span class="dropdown-item">
                    <a href="/tasks/${task.id}/edit">
                        <i class="fas fa-pen mx-2"></i> 
                        <button class="btn btn-primary">Update</button>
                    </a>
                </span>
            </li>
            <li>
                <span class="dropdown-item">
                    <i class="fas fa-trash mx-2"></i>
                    <form method="POST" action="/tasks/${task.id}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </span>
            </li>
        </ul>
    </li>`;
    }




    $(function() {
        $(".user-image").click(function() {
            var userId = $(this).data("user-id");
            var user_name = $(this).data("user-name");

            // Make an AJAX request to fetch tasks assigned to the user
            
            $.ajax({
                url: "/tasks/user/" + userId, // Update the URL to match your route
                method: "GET",
                success: function(data) {

                    console.log("Tasks assigned to user with ID " + userId, data);
                    $('#indivisual_user_name').text("Task's of: " + user_name);
                    const pendingTasks = data.filter(function(task) {
                        return task.status === 'pending';
                    });
                    const on_progress_task = data.filter(function(task) {
                        return task.status === 'on-progress';
                    });
                    const completedTask = data.filter(function(task) {
                        return task.status === 'completed';
                    });
                    const acceptedTasks = data.filter(function(task) {
                        return task.status === 'accepted';
                    });



                    $("#pending-item-drop").empty();
                    $("#on-progress-item-drop").empty();
                    $("#completed-item-drop").empty();
                    $("#accepted-item-drop").empty();

                    pendingTasks.forEach(task => {
                        if (task) {
                            $('#pending-item-drop').append(individual_task(task));
                        }
                    });
                    completedTask.forEach(task => {
                        if (task) {
                            $('#completed-item-drop').append(individual_task(task));
                        }
                    });
                    on_progress_task.forEach(task => {
                        if (task) {
                            $('#on-progress-item-drop').append(individual_task(task));

                        }
                    });
                    acceptedTasks.forEach(task => {
                        if (task) {
                            $('#accepted-item-drop').append(individual_task(task));

                        }
                    });


                },
                error: function(xhr, status, error) {
                    console.error("Error loading tasks: " + error);
                }
            });
        });
    });
</script>


<!-- for three dot  drop-down feature -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>












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
        <th>Priority</th>
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
        <td>{{$task->priority}}</td>
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

@endsection