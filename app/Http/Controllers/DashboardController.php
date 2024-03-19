<?php

namespace App\Http\Controllers;
Use App\Models\Student;
Use App\Models\Lecturer;
Use App\Models\Course;
Use App\Models\Trainer;
Use App\Models\Trainee;
Use App\Models\TraineeSession;
Use App\Models\Lab;
Use App\Models\Visitor;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $students=Student::all()->count();
        $lectures=Lecturer::all()->count();
        $courses=Course::all()->count();
        $trainers=Trainer::all()->count();
        $trainee=Trainee::all()->count();
        $projects=TraineeSession::all()->count();
        $labs=Lab::all()->count();
        $visitors=Visitor::all()->count();
        return view('admin.index',compact('students','lectures','courses','trainers','trainee','projects','labs','visitors'));
    }
}
