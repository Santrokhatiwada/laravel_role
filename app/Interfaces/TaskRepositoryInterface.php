<?php

namespace App\Interfaces;

interface TaskRepositoryInterface 
{
    public function getAllTasks();
    public function createTask();
    public function storeTask($data);
    
}
