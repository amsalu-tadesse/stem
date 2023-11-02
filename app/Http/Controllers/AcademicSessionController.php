<?php

namespace App\Http\Controllers;

use App\DataTables\AcademicSessionDataTable;
use App\Models\AcademicSession;
use App\Http\Requests\StoreAcademicSessionRequest;
use App\Http\Requests\StoreInstructorCourseRequest;
use App\Http\Requests\UpdateAcademicSessionRequest;
use App\Models\Course;
use App\Models\InstructorCourse;
use App\Models\Lecturer;

class AcademicSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AcademicSessionDataTable $dataTable)
    {
        return $dataTable->render('admin.academic-sessions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academic-sessions.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicSessionRequest $request)
    {
        AcademicSession::create($request->validated());
        return redirect()->route('admin.academic-sessions.index')->with('success_create', 'academic-sessions added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicSession $academic_session)
    {
        $students = AcademicSession::with('students.school')->find($academic_session);

        $courses = InstructorCourse::where('academic_session_id', $academic_session->id)
            ->with('course', 'instructor')
            ->get();

        $coursesNotInInstructorCourse = Course::whereDoesntHave('instructorCourses')->get();
        $instructorsNotInInstructorCourse = Lecturer::whereDoesntHave('instructorCourses')->get();

        return view('admin.academic-sessions.show', compact('students', 'courses', 'academic_session', 'coursesNotInInstructorCourse', 'instructorsNotInInstructorCourse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicSession $academic_session)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['academic_session'] = $academic_session;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicSessionRequest $request, AcademicSession $academic_session)
    {
        // if (request()->ajax()) {
        //     if($academic_session->status == 0){
        //         $academic_session->status = 1; 
        //         $academic_session->save(); 
        //     }else{
        //         $academic_session->status = 0; 
        //         $academic_session->save();  
        //     }
        // }
        $academic_session->update($request->validated());
        $academic_session->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicSession $academic_session)
    {
        if (!$academic_session->exists()) {
            return redirect()->route('admin.academic-sessions.index')->with('error', 'Unautorized!');
        }
        $academic_session->delete();
        return response()->json(array("success" => true), 200);
    }
}
