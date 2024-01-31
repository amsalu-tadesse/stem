<?php

namespace App\Http\Controllers;

use App\DataTables\GroupDataTable;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Center;
use App\Models\Lab;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class GroupController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(GroupDataTable $dataTable)
    {
        $labs = Lab::all();
        $centers = Center::all();
        return $dataTable->render('admin.groups.index',compact('labs','centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.groups.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {

        $group = Group::create($request->validated());

        return redirect()->route('admin.groups.index')->with('success_create', ' group added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['group'] = $group;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['group'] = $group;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {

        $group->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if (!$group->exists()) {
            return redirect()->route('admin.groups.index')->with('error', 'Unautorized!');
        }
        $group->delete();
        return response()->json(array('success' => true), 200);
    }
}
