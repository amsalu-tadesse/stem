<?php

namespace App\Http\Controllers;

use App\DataTables\TraineeGroupDataTable;
use App\Http\Requests\StoreGroupRequest;
use App\Models\TraineeGroup;
use App\Http\Requests\StoreTraineeGroupRequest;
use App\Http\Requests\UpdateTraineeGroupRequest;
use App\Models\Group;
use App\Models\Trainee;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class TraineeGroupController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(TraineeGroupDataTable $dataTable)
    {
        $groups = Group::all();
        $trainees = Trainee::all();
        return $dataTable->render('admin.trainee-groups.index', compact('groups', 'trainees',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::all();
        $trainees = Trainee::all();
        return view('admin.trainee-groups.new', compact('groups', 'trainees',));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreTraineeGroupRequest $request)
    {

        // dd(request()->all());
        $name = $request->input('name');
        $group_id = $request->input('group_id');
        $validatedTraineeGroupData = $request->input('selectedCheckboxes');
        // dd($validatedTraineeGroupData);
        if ($group_id !== null && $group_id !== '') {
            foreach ($validatedTraineeGroupData as $traineeId) {
                TraineeGroup::updateOrInsert(
                    ['trainee_id' => $traineeId],
                    ['group_id' => $group_id]
                );
                Trainee::where('id', $traineeId)->update(['grouped' => 1]);
            }
        }

        if ($name !== null && $name !== '') {
            $existingTraineeIds = TraineeGroup::whereIn('trainee_id', $validatedTraineeGroupData)->pluck('trainee_id')->toArray();

            $group = Group::create(['name' => $name]);
            $group_id = $group->id;
            // dd($validatedTraineeGroupData);
            foreach ($validatedTraineeGroupData as $traineeId) {
                if (in_array($traineeId, $existingTraineeIds)) {
                    TraineeGroup::where('trainee_id', $traineeId)->forceDelete();
                }

                // Create a new row
                TraineeGroup::create([
                    'group_id' => $group_id,
                    'trainee_id' => $traineeId,
                ]);

                Trainee::where('id', $traineeId)->update(['grouped' => 1]);
            }
        }
        return response()->json(['success' => true], 200);
    }



    /**
     * Display the specified resource.
     */
    public function show(TraineeGroup $trainee_group)
    {
        if (request()->ajax()) {
            $trainee_group->load('group:id,name')->load('trainee:id,full_name');
            $response = array();
            $response['success'] = 1;
            $response['trainee_group'] = $trainee_group;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TraineeGroup $trainee_group)
    {
        if (request()->ajax()) {
            $trainee_group->load('group:id,name')->load('trainee:id,full_name');
            $response = array();
            $response['success'] = 1;
            $response['trainee_group'] = $trainee_group;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTraineeGroupRequest $request, TraineeGroup $trainee_group)
    {

        $trainee_group->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TraineeGroup $trainee_group)
    {
        if (!$trainee_group->exists()) {
            return redirect()->route('admin.trainee-groups.index')->with('error', 'Unautorized!');
        }
        $trainee_group->delete();
        return response()->json(array('success' => true), 200);
    }
}
