<?php

namespace App\Http\Controllers;

use App\DataTables\InstructerCourseDataTable;
use App\Models\Instructor_course;
use App\Http\Requests\StoreInstructor_courseRequest;
use App\Http\Requests\UpdateInstructor_courseRequest;
use App\Models\InstructorCourse;

class InstructorCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InstructerCourseDataTable $dataTable)
    {
          return $dataTable->render("admin.instructer-courses.index");
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructor_courseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InstructorCourse $instructor_course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstructorCourse $instructor_course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructor_courseRequest $request, InstructorCourse $instructor_course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructorCourse $instructor_course)
    {
        //
    }
}
