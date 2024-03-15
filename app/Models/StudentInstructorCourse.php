<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInstructorCourse extends Model
{
    use HasFactory;
    protected $fillable=["student_id","instructor_course_id","mark"];
}
