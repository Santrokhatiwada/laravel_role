<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:project-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }



    public function index()
    {
        $users = User::get();

        $projects = Project::with('projectTasks')->latest()->paginate(5);




        return view('projects.index', compact('projects', 'users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::get();
        return view('projects.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'details' => 'required',
            'changer' => 'required|array',
        ]);

        $project = new Project;
        $project->name = $request->name;
        $project->details = $request->details;

        // Store the changers as JSON in the database
        $project->changer = json_encode($request->input('changer'));

        $project->save();
        return redirect()->route('projects.index')
            ->with('success', 'Product created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $user = User::get();

        // Retrieve user IDs that should be pre-selected (e.g., based on a relationship)
        $selectedUsers = $project->changer ? json_decode($project->changer, true) : [];

        return view('projects.edit', compact('project', 'user', 'selectedUsers'));
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
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'changer' => 'required|array',
        ]);

        $project = Project::find($id); // Find the existing project by ID

        if (!$project) {
            return redirect()->route('projects.index')
                ->with('error', 'Project not found.');
        }

        $project->name = $request->name;
        $project->details = $request->details;
        $project->changer = json_encode($request->input('changer'));
        $project->save();

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    public function showTasks(Project $project)
    {



        return redirect()->route('tasks.index', ['project' => $project->id]);
    }


    public function createTasks(Project $project)
    {

        return redirect()->route('tasks.create', ['project' => $project->id]);
    }

    public function allTasks(Project $project, $id)
    {


        $task = $project->projectTasks->find($id);



        return redirect()->route('tasks.show', ['project' => $project->id, 'task' => $task->id]);
    }


    public function editTask(Project $project, $id)
    {

        $task = $project->projectTasks->find($id);



        return redirect()->route('tasks.edit', ['project' => $project->id, 'task' => $task->id]);
    }
}
