<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{   
    use HasFactory;
    protected $fillable = [
        'task_name', 'description','status'
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'tasks_user','user_id','task_id');
    }
    
}

