<?php

namespace App\Http\Controllers;

use App\DataTables\EquipmentDataTable;
use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Center;
use App\Models\EquipmentType;
use App\Models\Lab;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class EquipmentController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(EquipmentDataTable $dataTable)
    {
        $labs = Lab::all();
        $centers = Center::all();
        $equipment_types = EquipmentType::all();
        return $dataTable->render('admin.equipment.index', compact('labs','centers','equipment_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labs = Lab::all();
        return view('admin.equipment.new',compact('labs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        // dd($request->validated());
        if(request()->ajax()){
            $equipment= Equipment::create($request->validated()); 
            $equipment->current_quantity = $equipment->count;
            $equipment->save();
            return response()->json(array('success' => true), 200);
        }
        $equipment = Equipment::create($request->validated());
        $equipment->current_quantity = $equipment->count;
        $equipment->save();
        return redirect()->route('admin.equipment.index')->with('success_create', ' equipment added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        if (request()->ajax()) {
            $equipment->load('lab:id,name')->load('equipmentType:id,name')->load('measurement:id,name');
            $response['success'] = 1;
            $response['equipment'] = $equipment;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        if (request()->ajax()) {
            $equipment->load('lab:id,name')->load('equipmentType:id,name')->load('measurement:id,name');
            $response = array();
            $response['success'] = 1;
            $response['equipment'] = $equipment;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {

        $equipment->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        if (!$equipment->exists()) {
            return redirect()->route('admin.equipment.index')->with('error', 'Unautorized!');
        }
        $equipment->delete();
        return response()->json(array('success' => true), 200);
    }
}
