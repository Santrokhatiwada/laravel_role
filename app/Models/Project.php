<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory,LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
       
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'name', 'details',
    ];

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
    public function projectTasks(){
        return $this->hasManyThrough(Task::class, ProjectTask::class, 'project_id','id','id','task_id');
    }

}
