<?php

namespace App\Http\Controllers;

use App\DataTables\AcademicSessionDataTable;
use App\DataTables\AcademicSessionDetailDataTable;
use App\Models\AcademicSession;
use App\Http\Requests\StoreAcademicSessionRequest;
use App\Http\Requests\StoreInstructorCourseRequest;
use App\Http\Requests\UpdateAcademicSessionRequest;
use App\Models\Course;
use App\Models\InstructorCourse;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentInstructorCourse;

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
            ->with('course', 'instructor','labAssistant')
            ->get();


        $coursesNotInInstructorCourse = Course::whereDoesntHave('instructorCourses')->get();

        $lect = Lecturer::join('academic_levels', 'lecturers.academic_level_id', '=', 'academic_levels.id')
        ->where('academic_levels.type', 0)
        ->whereDoesntHave('instructorCourses')
        ->select(['lecturers.name as name','lecturers.id as id'])
        ->get();

        $labAssistantNotInInstructorCourse = Lecturer::join('academic_levels', 'lecturers.academic_level_id', '=', 'academic_levels.id')
        ->where('academic_levels.type', 1)
        ->whereDoesntHave('instructorCourses')->select(['lecturers.name as name','lecturers.id as id'])
        ->get();

        $existingMarks = StudentInstructorCourse::whereIn('student_id', $students->pluck('id'))
        ->get()
        ->groupBy('instructor_course_id','student_id');


        $student_not_add_in_this_as = Student::whereNull('academic_session')->get();


        return view('admin.academic-sessions.show', compact('students','existingMarks', 'courses', 'academic_session', 'coursesNotInInstructorCourse', 'lect','labAssistantNotInInstructorCourse','student_not_add_in_this_as'));
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



    public function saveMarks(Request $request)
    {
        $marksData = $request->input('marksData');

        foreach ($marksData as $data) {
            // Check if a record already exists for this student and course
            $existingMark = StudentInstructorCourse::where('student_id', $data['studentId'])
                ->where('instructor_course_id', $data['courseId'])
                ->first();

            if ($existingMark) {
                // If a record exists, update it
                $existingMark->update([
                    'mark' => $data['mark'],
                    // You might want to update other fields here if needed
                ]);
            } else {
                // If no record exists, create a new one
                StudentInstructorCourse::create([
                    'student_id' => $data['studentId'],
                    'instructor_course_id' => $data['courseId'],
                    'mark' => $data['mark'],
                    // You might want to handle other fields here
                ]);
            }
        }

        return response()->json(['success' => true]);
    }


    public function getStudent() {
        $academic_session_id = request()->academic_session;
        $course_id = request()->course_id;
        $students = AcademicSession::with('students.school')->find($academic_session_id);
        $courses = InstructorCourse::where('academic_session_id', $academic_session_id)
            ->with('course', 'instructor', 'labAssistant')
            ->where("course_id", $course_id)
            ->get();

            $existingMarks = StudentInstructorCourse::whereIn('instructor_course_id', $courses->pluck('id'))
            ->get()
            ->groupBy('instructor_course_id');
        $academic_session = AcademicSession::find($academic_session_id);
           // Prepare response data
           $response = [
            "students" => $students,
            "existing_marks" => $existingMarks
        ];

        // Return JSON response
        return response()->json($response);
    }





}
