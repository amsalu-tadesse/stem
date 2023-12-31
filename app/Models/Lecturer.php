<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Lecturer extends Model
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
    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function instructorCourses()
    {
        return $this->hasMany(InstructorCourse::class);
    }
    public function course()
    {
        return $this->belongsToMany(Course::class, 'instructor_courses', 'lecturer_id', 'course_id');
    }

}
