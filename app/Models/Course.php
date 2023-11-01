<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Course extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'name',
            'created_by',
            'created_at'
        ]);
    }

    public function lecture()
    {
        return $this->belongsToMany(Lecturer::class, 'instructor_courses', 'course_id', 'lecturer_id');
    }
    
}
