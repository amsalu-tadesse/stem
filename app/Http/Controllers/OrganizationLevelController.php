<?php

namespace App\Http\Controllers;

use App\DataTables\OrganizationLevelsDataType;
use App\Models\OrganizationLevel;
use App\Http\Requests\StoreOrganizationLevelRequest;
use App\Http\Requests\UpdateOrganizationLevelRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Spatie\Activitylog\Models\Activity;

class OrganizationLevelController extends Controller
{
    use ModelAuthorizable;

    /**
     * Display a listing of the resource.
     */
    public function index(
        OrganizationLevelsDataType $dataTable
    ) {
        /*$all = Activity::all();
        foreach($all as $activity)
        {
            $data = $activity->changes;
        }*/

        return $dataTable->render('admin.organizationLevels.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.organizationLevels.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationLevelRequest $request)
    {
        $organizationLevel = OrganizationLevel::create($request->validated());
        return redirect()->route('admin.organization-levels.index')->with('success_create', 'Organization Level added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationLevel $organizationLevel)
    {
        if (request()->ajax()) {
            $response = array();
                $creator = User::find($organizationLevel->created_by);
                $fName = $creator?->first_name;
                $mName = $creator?->middle_name;
                $lName = $creator?->last_name;
                $getCreatedBy = $fName. ' ' . $mName. ' ' .$lName ;
                $response['organizationLevel'] = $organizationLevel;
                $response['getCreatedBy'] = $getCreatedBy;
                $response['success'] = 1;
            
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationLevel $organizationLevel)
    {
        if (request()->ajax()) {
            $response = array();
            if (!empty($organizationLevel)) {
                $response['organizationLevel_id'] = $organizationLevel->id;
                $response['name'] = $organizationLevel->name;
                $response['description'] = $organizationLevel->description;
                $response['success'] = 1;
            } else {
                $response['success'] = 0;
            }

            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationLevelRequest $request, OrganizationLevel $organizationLevel)
    {
        $organizationLevel->update($request->validated());

        $organizationLevel->save();

        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationLevel $organizationLevel)
    {
        if (!$organizationLevel->exists()) {
            return redirect()->route('admin.organizationLevels.index')->with('error', 'Unautorized!');
        }
        $organizationLevel->delete();
        return response()->json(array("success" => true), 200);
    }
}
