<?php

namespace App\Repositories;


use App\Interfaces\TaskRepositoryInterface;
use App\Models\Product;
use App\Models\Task;
use App\Models\User;

class TaskRepository implements TaskRepositoryInterface 
{
    public function getAllTasks() 
    {
        return Task::latest()->paginate(10);
    }

    public function storeTask($data)
    {
        return Task::create($data);
    }

    public function createTask(){
        return User::get();

    }
   
}
