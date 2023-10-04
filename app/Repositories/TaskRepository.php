<?php

namespace App\Repositories;


use App\Interfaces\TaskRepositoryInterface;
use App\Models\Product;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Notifications\TaskNotification;

use Illuminate\Support\Facades\Notification;
use Spatie\ModelStatus\Status;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks()
    {
        $task = Task::with('taskUser', 'statuses')->orderBy('priority', 'asc')
            ->latest()
            ->paginate(10);
         
            $user = User::get();


            return [
                'task' => $task,
                'user' => $user,
            ];
    }

    public function storeTask($data)
    {

        $task = Task::create($data);
        


        $task->setStatus('pending');


        $task->assignUser()->create([
            'user_id' => $data['user_id'],
        ]);
       
     
        $taskName= $task['task_name'];
        $status = 'created';
        $user = User::find($data['user_id']);
       
    
        // Use the Mail facade to send a test email notification
        Notification::send($user, new TaskNotification($status,$taskName,$user));   

        return $task;
    }

    public function createTask()
    {
        return User::get();
    }

    public function findTask($id)
    {

        $task = Task::with('taskUser')->find($id);
        $user = User::get();


        return [
            'task' => $task,
            'user' => $user,
        ];
    }

    public function updateTask($id, $data)
    {

         
        $task = Task::find($id);
     
       

        if (!$task) {
            // Handle the case where the task doesn't exist
            return response()->json(['error' => 'Task not found'], 404);
        }


        $task->update($data);
      
      

        if (isset($data['new_status']) && in_array($data['new_status'], ['pending','on-progress', 'completed', 'accepted'])) {
            // Update the status to the new value

            $task->setStatus($data['new_status']);

        }

      

      

        // Check if the user_id is provided and different from the existing assignment

        if (isset($data['user_id']) && ($task->assignUser ? $data['user_id'] !== $task->assignUser->user_id : true)) {
            if ($task->assignUser) {
                $task->assignUser->update([
                    'user_id' => $data['user_id'], // Set it to null or the new user's ID
                ]);
            } else {
                // Create a new assignment if it doesn't exist
                $task->assignUser()->create([
                    'user_id' => $data['user_id'],
                ]);
            }
        }

        $taskName= $task['task_name'];

        if ($data['new_status'] == 'on-progress' || $data['new_status'] == 'completed') {
            $status = $data['new_status'];
        
            $user = User::find($task['assigner_id']);
         
            $taskUser= User::find($data['user_id']);
            
      
            
            Notification::send($user, new TaskNotification($status,$taskName,$taskUser));
        }

        if ($data['new_status'] == 'accepted' ) {
            $status = $data['new_status'];
            $user = User::find($data['user_id']);
            Notification::send($user, new TaskNotification($status,$taskName,$user));
        }



        return $task;
    }

    public function deleteTask($id)
    {

        $task = Task::find($id);

        $task->delete();
    }

    public function updateUser($id, $data)
    {
        $task = Task::find($id);
        return $task->update($data);
    }


    public function getProfile($id)
    {
        $user = User::find($id);
        $tasks = $user->userTask()->get();
        
        
    $taskUsers = $tasks->pluck('taskUser')->pluck('name')->toArray();
    
    $statuses = $tasks->pluck('statuses')->map->last()->pluck('name')->toArray();

    $tasks = $tasks->map(function ($task, $key) use ($taskUsers, $statuses) {
        $task['taskUser'] = $taskUsers[$key];
        $task['status'] = $statuses[$key];
        return $task;
    });

   

    return $tasks;

    }

}
