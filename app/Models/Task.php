<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\ModelStatus\HasStatuses;
use Spatie\ModelStatus\Status;

class Task extends Model
{   
    use HasFactory, HasStatuses,LogsActivity;
    
    public function statuses()
    {
        return $this->morphMany(Status::class, 'model');
    }
    
    protected $fillable = [
        'task_name', 'description','deadline','status','assigner_id',
    ];
   

    public function taskUser()
{
    return $this->hasOneThrough(User::class, TaskUser::class, 'task_id','id','id','user_id');
}

public function assignUser()
{
    return $this->hasOne(TaskUser::class);
}
   
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults();
   
    // Chain fluent methods for configuration options
}

    
}

