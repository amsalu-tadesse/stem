<?php

namespace App\Http\Controllers;

use App\DataTables\EquipmentDataTable;
use App\DataTables\EquipmentForLabDataTable;
use App\DataTables\LabDataTable;
use App\Models\Lab;
use App\Http\Requests\StoreLabRequest;
use App\Http\Requests\UpdateLabRequest;
use App\Models\Center;
use App\Models\Measurement;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class LabController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(LabDataTable $dataTable)
    {
        $centers = Center::all();
        return $dataTable->render('admin.labs.index', compact('centers',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = Center::all();
        return view('admin.labs.new', compact('centers',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLabRequest $request)
    {
        $lab = Lab::create($request->validated());
        return redirect()->route('admin.labs.index')->with('success_create', ' lab added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lab $lab)
    {
        if (request()->ajax()) {
            $lab->load('center:id,name');
            $response = array();
            $response['success'] = 1;
            $response['lab'] = $lab;
            return response()->json($response);
        }
    }

    public function list(Lab $lab, EquipmentForLabDataTable $dataTable)
    {
        $equipment = Equipment::where('lab_id', $lab->id)->with('lab')->get();
        $labs = Lab::all();
        $equipment_types = EquipmentType::all();
        $measurements = Measurement::all();
        return $dataTable
            ->with(['lab_id' => $lab->id])
            ->render('admin.labs.list', compact('equipment', 'lab', 'labs', 'equipment_types','measurements'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {
        if (request()->ajax()) {
            $lab->load('center:id,name');
            $response = array();
            $response['success'] = 1;
            $response['lab'] = $lab;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLabRequest $request, Lab $lab)
    {

        $lab->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lab $lab)
    {
        if (!$lab->exists()) {
            return redirect()->route('admin.labs.index')->with('error', 'Unautorized!');
        }
        $lab->delete();
        return response()->json(array('success' => true), 200);
    }
}
