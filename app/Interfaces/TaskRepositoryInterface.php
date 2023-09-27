<?php

namespace App\Interfaces;

interface TaskRepositoryInterface 
{
    public function getAllTasks();
    public function createTask();
    public function storeTask($data);
    public function findTask($id);
    public function updateTask($id, $data);
    public function deleteTask($id);
    public function updateUser($id,$data);
    
}
