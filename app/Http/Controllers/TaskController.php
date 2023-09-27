<?php

namespace App\Http\Controllers;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

use Spatie\ModelStatus\Status;

class TaskController extends Controller
{



    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
        $this->taskRepository = $taskRepository;
    }
    public function index()
    {

        $tasks = $this->taskRepository->getAllTasks();

        $allpending = Status::where('name', 'pending')
            ->orderBy('id', 'DESC')->get();

        $allprogress = Status::whereIn('name', ['on-prgoress'])->get();
        $allcompleted = Status::whereIn('name', ['completed'])->get();
        $allaccepted = Status::whereIn('name', ['accepted'])->get();
        $allrejected = Status::whereIn('name', ['rejected'])->get();



        return view('tasks.index', compact('tasks', 'allpending', 'allprogress', 'allcompleted', 'allaccepted', 'allrejected'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->taskRepository->createTask();
        return view('tasks.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'task_name' => 'required',
            'description' => 'required',
            'assigner_id' => 'required|integer',
            'user_id' => 'nullable',
            'deadline' => 'nullable',



        ]);

        $data['assigner_id'] = intval($request->assigner_id);
        $data['user_id'] = intval($request->user_id);

        $tasks = $this->taskRepository->storeTask($data);



        return redirect()->route('tasks.index', compact('tasks'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {

        $result = $this->taskRepository->findTask($id);
        $task = $result['task'];
        $user = $result['user'];

        return view('tasks.show', compact('task', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = $this->taskRepository->findTask($id);

        $task = $result['task'];
        $user = $result['user'];



        return view('tasks.edit', compact('task', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'task_name' => 'nullable',
            'description' => 'nullable',
            'assigner_id' => 'integer',
            'user_id' => 'nullable',
            'deadline' => 'nullable',
            'new_status' => 'required',

        ]);


        // $data['assigner_id'] = intval($request->assigner_id);

        $data['user_id'] = intval($request->user_id);



        $task = $this->taskRepository->updateTask($id, $data);

        return redirect()->route('tasks.index', compact('task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->taskRepository->deleteTask($id);
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
    }

    // public function updateStatus(Request $request, $id){


    //     $data = $request->validate([
    //         'task_name' => 'nullable',
    //         'description' => 'nullable',
    //         'assigner_id' => 'nullable',
    //         'user_id' => 'nullable',
    //         'status'=>'required',

    //     ]);
    //    $status= $this->taskRepository->updateUser($id, $data);
    //     return redirect()->route('tasks.index', compact('status'));

    // }

    public function update_task(Request $request, Task $task)
    {
        $status = $request->get('status');
        $id = $request->get('id');

        $task = Task::find($id);
        $task->statuses = $status;
        $task->save();
        return 'Task Update successfully.';
    }



    public function taskNotification()
    {


        if (Auth::user()->getRoleNames()->contains('SuperAdmin')){
            $notifications = [];

            $users = User::all();

            foreach ($users as $user) {
                $userNotifications = $user->notifications
                    ->where('notifiable_id','=' ,Auth::id())
                    ->pluck('data')
                    ->toArray();
    
                $notifications = array_merge($notifications, $userNotifications);
            }
            return response()->json($notifications);
        }

        if (Auth::user()->getRoleNames()->contains('User')){

            $notifications = Auth::user()->notifications->pluck('data');
          


            return response()->json($notifications);
        }
    }
}
