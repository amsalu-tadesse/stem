<?php

namespace App\Http\Controllers;

use App\DataTables\OrganizationTypeDataTable;
use App\Models\OrganizationType;
use App\Http\Requests\StoreOrganizationTypeRequest;
use App\Http\Requests\UpdateOrganizationTypeRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;

class OrganizationTypeController extends Controller
{
    use ModelAuthorizable;

    /**
     * Display a listing of the resource.
     */
    public function index(OrganizationTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.organizationTypes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.organizationTypes.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationTypeRequest $request)
    {
        $organizationType = OrganizationType::create($request->validated());
        return redirect()->route('admin.organization-types.index')->with('success_create', 'Organization Type added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationType $organizationType)
    {
        if (request()->ajax()) {
            $response = array();
                $creator = User::find($organizationType->created_by);
                $fName = $creator?->first_name;
                $mName = $creator?->middle_name;
                $lName = $creator?->last_name;
                $getCreatedBy = $fName. ' ' . $mName. ' ' .$lName ;
                $response['organizationType'] = $organizationType;
                $response['getCreatedBy'] = $getCreatedBy;
                $response['success'] = 1;

            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationType $organizationType)
    {
        if (request()->ajax()) {
            $response = array();
            if (!empty($organizationType)) {
                $response['organizationType_id'] = $organizationType->id;
                $response['name'] = $organizationType->name;
                $response['description'] = $organizationType->description;
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
    public function update(UpdateOrganizationTypeRequest $request, OrganizationType $organizationType)
    {
        $organizationType->update($request->validated());
        $organizationType->save();

        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationType $organizationType)
    {
        if (!$organizationType->exists()) {
            return redirect()->route('admin.organizationTypes.index')->with('error', 'Unautorized!');
        }
        $organizationType->delete();
        return response()->json(array("success" => true), 200);
    }
}
