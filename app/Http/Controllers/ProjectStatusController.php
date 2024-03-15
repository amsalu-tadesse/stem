<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use App\DataTables\ProjectProgressDataTable;
use App\DataTables\ProjectStatusDataTable;
use App\Http\Requests\StoreProjectStatusRequest;
use App\Http\Requests\UpdateProjectStatusRequest;

class ProjectStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectStatusDataTable $dataTable)
    {
        return $dataTable->render('admin.project-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.project-status.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectStatusRequest $request)
    {
        ProjectStatus::create($request->validated());
        return redirect()->route('admin.project-status.index')->with('success_create', 'project Status added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectStatus $projectStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectStatus $projectStatus)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['projectStatus'] = $projectStatus;
            
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectStatusRequest $request, ProjectStatus $projectStatus)
    {
        $projectStatus->update($request->validated());
        $projectStatus->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectStatus $projectStatus)
    {
        if (!$projectStatus->exists()) {
            return redirect()->route('admin.project-status.index')->with('error', 'Unautorized!');
        }
        $projectStatus->delete();
        return response()->json(array("success" => true), 200);
    }
}
