<?php

namespace App\Http\Controllers;

use App\DataTables\StudentDataTable;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\AcademicSession;
use App\Models\School;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StudentDataTable $dataTable)
    {
        $schools = School::all();
        $academic_sessions = AcademicSession::all();
        return $dataTable->render('admin.students.index',compact('schools','academic_sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $academic_sessions = AcademicSession::all();
        return view('admin.students.new',compact('schools','academic_sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());
        return redirect()->route('admin.students.index')->with('success_create', 'student added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['student'] = $student;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        $student->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if (!$student->exists()) {
            return redirect()->route('admin.students.index')->with('error', 'Unautorized!');
        }
        $student->delete();
        return response()->json(array("success" => true), 200);
    }
}
