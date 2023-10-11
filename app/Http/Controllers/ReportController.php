<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {

    //     $projectNames = DB::table('projects')
    //         ->selectRaw('Name')
    //         ->get();

    //     $taskNames = DB::table('tasks')
    //         ->selectRaw('tasks.task_name')
    //         ->Join('project_tasks', 'tasks.id', '=', 'project_tasks.task_id')
    //         ->get();



    //     $taskUsers = DB::table('users')
    //         ->selectRaw('users.name')
    //         ->Join('task_users', 'users.id', '=', 'task_users.user_id')
    //         ->get();

    //     $status = DB::table('statuses')
    //         ->selectRaw('statuses.name')
    //         ->Join('tasks', 'statuses.model_id', '=', 'tasks.id')
    //         ->get();







    //     return view('reports.index', compact('projectNames', 'taskNames', 'taskUsers', 'status'));
    // }
    public function index()
    {
        // $projects = DB::table('projects')
        //     ->select('id', 'Name')
        //     ->get();

        // $projects = DB::select("SELECT projects.id,projects.name
        // from projects
        // ");

        // $reportData = [];

        // foreach ($projects as $project) {
        //     // $tasks = DB::table('tasks')
        //     //     ->select('tasks.task_name', 'task_users.user_id', 'users.name', 'tasks.id')
        //     //     ->join('project_tasks', 'tasks.id', '=', 'project_tasks.task_id')
        //     //     ->Join('task_users', 'tasks.id', '=', 'task_users.task_id')
        //     //     ->Join('users', 'users.id', '=', 'task_users.user_id')

        //     //     ->where('project_tasks.project_id', $project->id)
        //     //     ->get();


        //     $tasks = DB::select("SELECT tasks.task_name,tasks.id,task_users.user_id,users.name 
        //     From tasks
        //     join project_tasks on tasks.id = project_tasks.task_id
        //     Join task_users on tasks.id = task_users.task_id
        //     join users on users.id = task_users.user_id
        //      where project_tasks.project_id = {$project->id} ");




        //     foreach ($tasks as $task) {
        //         $lastStatus = DB::table('statuses')
        //             ->select('statuses.name')
        //             ->join('tasks', 'statuses.model_id', '=', 'tasks.id')
        //             ->where('tasks.id', $task->id)
        //             ->latest('statuses.updated_at')
        //             ->first();

        //         $lastStatus = DB::select("SELECT statuses.name
        //         from statuses
        //         join tasks on statuses.model_id=tasks.id
        //         where tasks.id = {$task->id}
        //         ORDER BY statuses.updated_at DESC
        //        LIMIT 1
        //         ");

        //         $task->lastStatus = $lastStatus;
        //     }

        //     $reportData[] = [
        //         'project' => $project,
        //         'tasks' => $tasks,

        //     ];
        // }



        $reportData = DB::select("SELECT
        projects.id AS project_id,
        projects.name AS project_name,
        tasks.task_name,
        users.name AS user_name,
        statuses.name AS status_name
    FROM
        projects
    INNER JOIN project_tasks ON projects.id = project_tasks.project_id
    INNER JOIN tasks ON project_tasks.task_id = tasks.id
    INNER JOIN task_users ON tasks.id = task_users.task_id
    INNER JOIN users ON task_users.user_id = users.id
    LEFT JOIN statuses ON statuses.model_id = tasks.id
    AND statuses.updated_at = (
        SELECT MAX(updated_at)
        FROM statuses
        WHERE model_id = tasks.id
    )
    GROUP BY
        projects.id,
        projects.name,
        tasks.id,
        tasks.task_name,
        users.name,
        statuses.name
    ORDER BY
        projects.id ASC;
    ");





        return view('reports.index', compact('reportData'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
