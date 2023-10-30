<?php

namespace App\Http\Controllers;

use App\DataTables\CourseDataTable;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CourseDataTable $dataTable)
    {
        return $dataTable->render('admin.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());
        return redirect()->route('admin.courses.index')->with('success_create', 'course added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['course'] = $course;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        $course->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if (!$course->exists()) {
            return redirect()->route('admin.courses.index')->with('error', 'Unautorized!');
        }
        $course->delete();
        return response()->json(array("success" => true), 200);
    }
}
