<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolLevelDataTable;
use App\Models\SchoolLevel;
use App\Http\Requests\StoreSchoolLevelRequest;
use App\Http\Requests\UpdateSchoolLevelRequest;

class SchoolLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SchoolLevelDataTable $dataTable)
    {
        return $dataTable->render('admin.school-levels.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-levels.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolLevelRequest $request)
    {
         SchoolLevel::create($request->validated());
        return redirect()->route('admin.school-levels.index')->with('success_create', 'school-levels added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolLevel $school_level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolLevel $school_level)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['school_level'] = $school_level;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolLevelRequest $request, SchoolLevel $school_level)
    {
        $school_level->update($request->validated());
        $school_level->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolLevel $school_level)
    {
        if (!$school_level->exists()) {
            return redirect()->route('admin.school-levels.index')->with('error', 'Unautorized!');
        }
        $school_level->delete();
        return response()->json(array("success" => true), 200);
    }
}
