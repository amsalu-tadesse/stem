<?php

namespace App\Http\Controllers;

use App\DataTables\OrganizationDataTable;
use App\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Models\OrganizationLevel;
use App\Models\OrganizationType;
use App\Models\Region;
use App\Models\User;
use App\Models\Zone;
use App\Traits\ModelAuthorizable;

class OrganizationController extends Controller
{
    use ModelAuthorizable;

    /**
     * Display a listing of the resource.
     */
    public function index(OrganizationDataTable $dataTable)
    {
        $levels = OrganizationLevel::all();
        $regions = Region::all('id', 'name', 'is_cityadministration');
        $zones = Zone::orderBy('name', 'asc')->get();
        $organization_types = OrganizationType::select('id', 'name')->get();
        return $dataTable->render('admin.organizations.index', compact('organization_types', 'levels', 'regions', 'zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organization_types = OrganizationType::all();
        $levels = OrganizationLevel::all();
        $regions = Region::all();
        $zones = Zone::orderBy('name', 'asc')->get();
        return view('admin.organizations.new', compact('organization_types', 'levels', 'regions', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {
        Organization::create($request->validated());

        return redirect()->route('admin.organizations.index')->with('success_create', 'Organization added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        if (request()->ajax()) {
            $response = array();
            $response['organization_id'] = $organization->id;
            $response['name'] = $organization?->name;
            $response['description'] = $organization?->description;
            $response['organization_type_id'] = $organization->organizationType?->name;
            $response['organization_level_id'] = $organization->organizationLevel?->name;
            $region = $organization->region?->name;
            $zone = $organization->zone?->name;
            $response['region_id'] = $region;
            $response['zone_id'] = $zone;
            $creator = User::find($organization->created_by);
            $fName = $creator?->first_name;
            $mName = $creator?->middle_name;
            $lName = $creator?->last_name;
            $getCreatedBy = $fName . ' ' . $mName . ' ' . $lName;
            // $response['getCreatedBy'] = $getCreatedBy;
            $response['created_at'] = $organization->created_at;
            $response['success'] = 1;

            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        if (request()->ajax()) {
            $organization
                ->load('region:id,name')
                ->load('organizationLevel:id,name')
                ->load('zone:id,name');

            $response = array();

            $response['success'] = 1;
            $response['organization'] = $organization;

            return response()->json($response);
        }
    }

    public function authorizeOrganization(Organization $organization)
    {
        $organization->status = 1;
        $organization->save();
        return response()->json(array("success" => true), 200);
    }
    public function unAuthorizeOrganization(Organization $organization)
    {
        $organization->status = 0;
        $organization->save();
        return response()->json(array("success" => true), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        //update organization modal
        if (request()->ajax() and request()->isMethod('patch')) {
            $validated_data = $request->validated();
            $organization->region_id=null;
            $organization ->zone_id = null;

            $organization->update($validated_data);

        }
        return response()->json(array("success" => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        if (!$organization->exists()) {
            return redirect()->route('admin.organizations.index')->with('error', 'Unautorized!');
        }
        $organization->delete();
        return response()->json(array("success" => true), 200);
    }
}
