<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\School;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\App;
use App\DataTables\StudentDataTable;
use Illuminate\Support\Facades\View;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

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
    public function certificate(Request $request){
        // Prepare the data to be passed to the view
        $selectedCheckboxes = $request->input('values');
        $integers = array_map('intval', explode(',',$selectedCheckboxes));
        $students = Student::findMany($integers);
        $stores = [];

        foreach ($students as $studentObj) {
            $marks = Student::join("student_instructor_courses", "student_instructor_courses.student_id", "=", "students.id")
                ->where("students.id", $studentObj->id)
                ->pluck("student_instructor_courses.mark")
                ->toArray();

            $sum = array_sum($marks);

            if ($sum >= 50) {
                $data = [
                    'studentName' => $studentObj->name,
                    'startDate' => '2023-01-01',
                    'endDate' => '2023-12-31',
                    'issuedDate' => date('Y-m-d'),
                    'yourName' => 'Yonas Tesfaye',
                    'yourPosition' => 'Stem Head',
                    'institution' => 'AASTU'
                ];
                $stores[] = $data;
            }
        }

        // If there are students eligible for certificates, generate and download the PDF
        if (!empty($stores)) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->setOptions(['fontDir' => public_path('fonts/')]);
            $pdf->setOptions(['defaultFont' => 'washrab']);
            $pdf->loadHTML(View::make('admin.certificate.index', compact('stores'))->render());
            return $pdf->download('certificate.pdf');
        } else {
            return back(); // No students eligible for certificates, return back
        }
    }



    }

