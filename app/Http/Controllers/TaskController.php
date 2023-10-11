<?php

namespace App\Http\Controllers;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
    public function index(Request $request)
    {
        // Check if the project ID is present in the URL query parameters
        $projectId = $request->input('project');



        // if (!isset($_GET['project']) && Auth::user()->getRoleNames()->contains('User') && Gate::denies('project-list')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Fetch the tasks, users, and the project
        $result = $this->taskRepository->getAllTasks();

        $tasks = $result['tasks'];
        $users = $result['users'];


        $uniqueUsers = [];

        foreach ($tasks as $task) {

            if ($task->taskUser && !in_array($task->taskUser->id, array_column($uniqueUsers, 'id'))) {
                $uniqueUsers[] = [
                    'id' => $task->taskUser->id,
                    'name' => $task->taskUser->name,
                    'image' => $task->taskUser->image,
                ];
            }
        }


        // Load the project based on the $projectId if it's available
        $project = $projectId ? Project::find($projectId) : null;







        if (request()->expectsJson()) {
            return response()->json(['tasks' => $tasks, 'users' => $users]);
        } else {
            return view('tasks.index', compact('tasks', 'users', 'project', 'uniqueUsers'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Gate::denies('project-create')) {
            abort(403, 'Unauthorized action.');
        }
        $result = $this->taskRepository->createTask();

        $project = $result['projects'];
        $user = $result['user'];
        $projectId = $result['projectId'];

        return view('tasks.create', compact('user', 'project', 'projectId'));
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
            'priority' => 'nullable',
            'project_id' => 'nullable',

        ]);



        $data['assigner_id'] = intval($request->assigner_id);
        $data['user_id'] = intval($request->user_id);

        $project = $data['project_id'];

        $tasks = $this->taskRepository->storeTask($data);



        return redirect()->route('projects.tasks.index', ['project' => $project, 'tasks' => $tasks]);
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

        if (isset($_GET['project'])) {
            $projectId = $result['projectId'];
            return view('tasks.show', compact('task', 'user', 'projectId'));
        } else {
            return view('tasks.show', compact('task', 'user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('project-edit')) {
            abort(403, 'Unauthorized action.');
        }
        $result = $this->taskRepository->findTask($id);

        $task = $result['task'];
        $user = $result['user'];
        $projectId = $result['projectId'];



        return view('tasks.edit', compact('task', 'user', 'projectId'));
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
            'assigner_id' => 'nullable',
            'user_id' => 'nullable',
            'deadline' => 'nullable',
            'new_status' => 'required',
            'project_id' => 'nullable',
        ]);
        if ($data['project_id']) {
            $project = $data['project_id'];
        }


        // $data['assigner_id'] = intval($request->assigner_id);

        $data['user_id'] = intval($request->user_id);



        $task = $this->taskRepository->updateTask($id, $data);

        if ($data['project_id']) {
            return redirect()->route('projects.tasks.index', ['project' => $project, 'task' => $task]);
        } else {
            return redirect()->route('tasks.index', compact('task'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('project-delete')) {
            abort(403, 'Unauthorized action.');
        }
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


        if (Auth::user()->getRoleNames()->contains('SuperAdmin')) {
            $notifications = [];

            $users = User::all();

            foreach ($users as $user) {
                $userNotifications = $user->notifications
                    ->where('notifiable_id', '=', Auth::id())
                    ->pluck('data')
                    ->toArray();

                $notifications = array_merge($notifications, $userNotifications);
            }
            return response()->json($notifications);
        }

        if (Auth::user()->getRoleNames()->contains('User')) {

            $notifications = Auth::user()->notifications->pluck('data');



            return response()->json($notifications);
        }
    }



    public function profile($userId)
    {

        $tasks = $this->taskRepository->getProfile($userId);
        return $tasks;
    }
}
