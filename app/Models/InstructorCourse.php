<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InstructorCourse extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $fillable = ['course_id', 'lecturer_id', 'academic_session_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'course_id',
            'created_by',
            'created_at'
        ]);
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function instructor()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}
