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
        $task = Task::with('taskUser', 'statuses')
            ->latest()
            ->paginate(10);


        return $task;
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
     



        $task->update($data);
       

        if (isset($data['new_status']) && in_array($data['new_status'], ['on-progress', 'completed', 'accepted', 'rejected'])) {
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

        if ($data['new_status'] == 'accepted' || $data['new_status'] == 'rejected') {
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
}
