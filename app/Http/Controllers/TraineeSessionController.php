<?php

namespace App\Http\Controllers;

use App\DataTables\TraineeSessionDataTable;
use App\Models\TraineeSession;
use App\Http\Requests\StoreTraineeSessionRequest;
use App\Http\Requests\UpdateTraineeSessionRequest;
use App\Models\Equipment;
use App\Models\Center;
use App\Models\Group;
use App\Models\FundType;
use App\Models\Lab;
use App\Models\GroupLab;
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
        $centers = Center::all();
        $groups = Group::all();
        $fund_types = FundType::all();
        $labs = Lab::all();
        $group_labs = GroupLab::all();
        $equipment = Equipment::all();

        return $dataTable->render('admin.trainee-sessions.index', compact('equipment','centers','groups','fund_types','labs','group_labs','equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = Center::all();
        $groups = Group::all();
        $fund_types = FundType::all();
        $labs = Lab::all();
        $group_labs = GroupLab::all();
        $equipment = Equipment::all();

        // dd($centers, $groups,$labs, $group_labs);
        return view('admin.trainee-sessions.new', compact('equipment', 'centers', 'groups', 'fund_types', 'labs', 'group_labs'));
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
                return response()->json(['error' => 'The request quantity is greater than available quantity.'], 422);
            }

            TraineeSessionEquipment::create([
                'equipment_id' => $equipId,
                'quantity' => $quantities[$key],
                'trainee_session_id' => $trainee_session->id,
            ]);

            // Update Equipment count
            $equip->current_quantity = $equip->current_quantity - $quantities[$key];
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
             $trainee_session->load('center:id,name')->load('group:id,name')->load('fundType:id,name');
            $response = [];
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
        $trainee_session->load('center:id,name')->load('group:id,name')->load('fundType:id,name');
        $equipment = Equipment::whereIn('id', TraineeSessionEquipment::where('trainee_session_id', $trainee_session->id)->pluck('equipment_id'))->get();
        
        $response = [];
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

        foreach ($equipmentIds as $key => $equipId) {
            $equip = Equipment::find($equipId);

            // Check if quantity is greater than available count
            if ($quantities[$key] > $equip->count) {
                return response()->json(['error' => 'Quantity is greater than available count.'], 422);
            }

            // Get the previous quantity
            $previousQuantity = TraineeSessionEquipment::where('trainee_session_id', $trainee_session->id)
                ->where('equipment_id', $equipId)
                ->value('quantity');

            // Calculate the difference between previous and current quantity

            $temp = $equip->current_quantity + $previousQuantity;
            $updated_quantity = $temp - $quantities[$key];
            // Update or create the TraineeSessionEquipment record
            TraineeSessionEquipment::updateOrInsert(
                [
                    'trainee_session_id' => $trainee_session->id,
                    'equipment_id' => $equipId,
                ],
                [
                    'quantity' => $quantities[$key],
                ],
            );
            // Update Equipment count

            $equip->current_quantity = $updated_quantity;
            $equip->save();
        }

        // Update TraineeSession if needed
        $trainee_session->update($request->validated());

        return response()->json(['success' => true], 200);
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
        return response()->json(['success' => true], 200);
    }
}
