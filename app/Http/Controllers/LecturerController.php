<?php

namespace App\Http\Controllers;

use App\DataTables\LecturerDataTable;
use App\Models\Lecturer;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Models\AcademicLevel;
use App\Models\Department;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LecturerDataTable $dataTable)
    {
        $departments = Department::all();
        $academic_levels = AcademicLevel::all();
        return $dataTable->render('admin.lecturers.index',compact('departments','academic_levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $academic_levels = AcademicLevel::all();
        return view('admin.lecturers.new',compact('departments','academic_levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLecturerRequest $request)
    {
        Lecturer::create($request->validated());
        return redirect()->route('admin.lecturers.index')->with('success_create', 'lecturer added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['lecturer'] = $lecturer;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLecturerRequest $request, Lecturer $lecturer)
    {
        $lecturer->update($request->validated());
        $lecturer->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        if (!$lecturer->exists()) {
            return redirect()->route('admin.lecturers.index')->with('error', 'Unautorized!');
        }
        $lecturer->delete();
        return response()->json(array("success" => true), 200);
    }
}
