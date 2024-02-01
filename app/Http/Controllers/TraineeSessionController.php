<?php

namespace App\Http\Controllers;

use App\DataTables\TraineeSessionDataTable;
use App\Models\TraineeSession;
use App\Http\Requests\StoreTraineeSessionRequest;
use App\Http\Requests\UpdateTraineeSessionRequest;
use App\Models\Equipment;
use App\Models\TraineeSessionEquipment;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class TraineeSessionController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(TraineeSessionDataTable $dataTable)
    {
        $equipment = Equipment::all();
        return $dataTable->render('admin.trainee-sessions.index', compact('equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipment = Equipment::all();
        return view('admin.trainee-sessions.new', compact('equipment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTraineeSessionRequest $request)
    {
        $equipmentIds = request()->input('equipment_id');
        $quantities = request()->input('quantity');
        $trainee_session = TraineeSession::create($request->validated());
        
        foreach ($equipmentIds as $key => $equipId) {
            $equip = Equipment::find($equipId);
        
            // Check if quantity is greater than available count
            if ($quantities[$key] > $equip->count) {
                // Handle the error, e.g., return a response, redirect, etc.
                return response()->json(['error' => 'Quantity is greater than available count.'], 422);
            }
        
            TraineeSessionEquipment::create([
                'equipment_id' => $equipId,
                'quantity' => $quantities[$key],
                'trainee_session_id' => $trainee_session->id,
            ]);
        
            // Update Equipment count
            $equip->count = $equip->count - $quantities[$key];
            $equip->save();
        }
        

        return redirect()->route('admin.trainee-sessions.index')->with('success_create', ' trainee_session added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TraineeSession $trainee_session)
    {
        if (request()->ajax()) {
            $equipment = Equipment::whereIn('id', TraineeSessionEquipment::where('trainee_session_id', $trainee_session->id)->pluck('equipment_id'))->get();
            $response = array();
            $response['success'] = 1;
            $response['trainee_session'] = $trainee_session;
            $response['equipment'] = $equipment;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TraineeSession $trainee_session)
    {
        if (request()->ajax()) {
            $trainee_session = TraineeSession::with('traineeSessionEquipment')->find($trainee_session->id);
            $equipment = Equipment::whereIn('id', TraineeSessionEquipment::where('trainee_session_id', $trainee_session->id)->pluck('equipment_id'))->get();
            $response = array();
            $response['success'] = 1;
            $response['trainee_session'] = $trainee_session;
            $response['equipment'] = $equipment;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTraineeSessionRequest $request, TraineeSession $trainee_session)
    {
        $equipmentIds = request()->input('equipment_id');
        $quantities = request()->input('quantity');
        $trainee_session = TraineeSession::create($request->validated());
        
        foreach ($equipmentIds as $key => $equipId) {
            $equip = Equipment::find($equipId);
        
            // Check if quantity is greater than available count
            if ($quantities[$key] > $equip->count) {
                // Handle the error, e.g., return a response, redirect, etc.
                return response()->json(['error' => 'Quantity is greater than available count.'], 422);
            }
        
            // Update or create the TraineeSessionEquipment record
            TraineeSessionEquipment::updateOrCreate(
                ['equipment_id' => $equipId, 'trainee_session_id' => $trainee_session->id],
                ['quantity' => $quantities[$key]]
            );
        
            // Update Equipment count
            $equip->count = $equip->count - $quantities[$key];
            $equip->save();
        }
        

        $trainee_session->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TraineeSession $trainee_session)
    {
        if (!$trainee_session->exists()) {
            return redirect()->route('admin.trainee-sessions.index')->with('error', 'Unautorized!');
        }
        $trainee_session->delete();
        return response()->json(array('success' => true), 200);
    }
}
