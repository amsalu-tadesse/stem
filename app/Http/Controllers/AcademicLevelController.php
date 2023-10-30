<?php

namespace App\Http\Controllers;

use App\DataTables\AcademicLevelDataTable;
use App\Models\AcademicLevel;
use App\Http\Requests\StoreAcademicLevelRequest;
use App\Http\Requests\UpdateAcademicLevelRequest;

class AcademicLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AcademicLevelDataTable $dataTable)
    {
        return $dataTable->render('admin.academic-levels.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academic-levels.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicLevelRequest $request)
    {
        AcademicLevel::create($request->validated());
        return redirect()->route('admin.academic-levels.index')->with('success_create', 'academic-levels added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicLevel $academic_level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicLevel $academic_level)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['academic_level'] = $academic_level;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicLevelRequest $request, AcademicLevel $academic_level)
    {
        $academic_level->update($request->validated());
        $academic_level->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicLevel $academic_level)
    {
        if (!$academic_level->exists()) {
            return redirect()->route('admin.academic-levels.index')->with('error', 'Unautorized!');
        }
        $academic_level->delete();
        return response()->json(array("success" => true), 200);
    }
}
