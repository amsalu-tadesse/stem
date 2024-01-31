<?php

namespace App\Http\Controllers;

use App\DataTables\GroupLabDataTable;
use App\Models\GroupLab;
use App\Http\Requests\StoreGroupLabRequest;
use App\Http\Requests\UpdateGroupLabRequest;
use App\Models\Center;
use App\Models\Group;
use App\Models\Lab;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class GroupLabController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(GroupLabDataTable $dataTable)
    {
        $groups = Group::all();
        $labs = Lab::all();
        return $dataTable->render('admin.group-labs.index', compact('groups', 'labs',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = DB::table('groups')->get();
        $labs = DB::table('labs')->get();
        return view('admin.group-labs.new', compact('groups', 'labs',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupLabRequest $request)
    {
        $lab_id = request()->input('lab_id');
        $validatedGroupData = request()->input('selectedCheckboxes');

        if ($lab_id !== null && $lab_id !== '') {
            GroupLab::whereIn('group_id', $validatedGroupData)->delete();

            foreach ($validatedGroupData as $groupId) {
                GroupLab::updateOrInsert(
                    ['group_id' => $groupId],
                    ['lab_id' => $lab_id]
                );

                Group::where('id', $groupId)->update(['added' => 1]);
            }
        }

        return response()->json(['success' => true], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(GroupLab $group_lab)
    {
        if (request()->ajax()) {
            $group_lab->load('group:id,name')->load('lab:id,name');
            $response = array();
            $response['success'] = 1;
            $response['group_lab'] = $group_lab;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroupLab $group_lab)
    {
        if (request()->ajax()) {
            $group_lab->load('group:id,name')->load('lab:id,name');
            $response = array();
            $response['success'] = 1;
            $response['group_lab'] = $group_lab;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupLabRequest $request, GroupLab $group_lab)
    {

        $group_lab->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupLab $group_lab)
    {
        if (!$group_lab->exists()) {
            return redirect()->route('admin.group-labs.index')->with('error', 'Unautorized!');
        }
        $group_lab->forceDelete();
        return response()->json(array('success' => true), 200);
    }
}
