<?php

namespace App\Http\Controllers;

use App\Models\InstructorCourse;
use App\Http\Requests\StoreInstructorCourseRequest;
use App\Http\Requests\UpdateInstructorCourseRequest;

class InstructorCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructorCourseRequest $request)
    {
        if (request()->ajax()) {
            InstructorCourse::create($request->validated());
            return response()->json(array("success" => true), 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InstructorCourse $instructorCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstructorCourse $instructorCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructorCourseRequest $request, InstructorCourse $instructorCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructorCourse $instructorCourse)
    {
        //
    }
}
