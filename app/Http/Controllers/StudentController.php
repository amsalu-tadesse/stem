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
    public function destroy(Student $student)
    {
        if (!$student->exists()) {
            return redirect()->route('admin.students.index')->with('error', 'Unautorized!');
        }
        $student->delete();
        return response()->json(array("success" => true), 200);
    }

    public function certificate(Request $request){
      // Prepare the data to be passed to the view
      $selectedCheckboxes = $request->input('values');

      $integers = array_map('intval', explode(',',$selectedCheckboxes));

      $result = array_map(function ($element) {
        return $element + 1;
    }, $integers);

      $student = Student::findMany($result);
      foreach ($student as $studentObj){

        $data = [
            'studentName' => $studentObj->name, // Replace with the actual student name
            'startDate' => '2023-01-01', // Replace with the actual start date
            'endDate' => '2023-12-31', // Replace with the actual end date
            'issuedDate' => date('Y-m-d'), // Current date
            'yourName' => 'Yonas Tesfaye', // Replace with the actual name
            'yourPosition' => 'Stem Head', // Replace with the actual position
            'institution' => 'AASTU' // Replace with the actual position
        ];

        // Return the PDF as a response
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('admin.certificate.index', $data)->render());
    
        
            // Generate the PDF
            
      return $pdf->stream( $studentObj ->name .' certificate.pdf');
      }
  

   


    }
}
