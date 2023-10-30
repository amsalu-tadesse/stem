<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolDataTable;
use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SchoolDataTable $dataTable)
    {
        return $dataTable->render('admin.schools.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.schools.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        School::create($request->validated());
        return redirect()->route('admin.schools.index')->with('success_create', 'schools added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['school'] = $school;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->update($request->validated());
        $school->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        if (!$school->exists()) {
            return redirect()->route('admin.schools.index')->with('error', 'Unautorized!');
        }
        $school->delete();
        return response()->json(array("success" => true), 200);
    }
}
