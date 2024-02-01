<?php 
namespace App\Http\Controllers;
use App\DataTables\TraineeSessionEquipmentDataTable;
use App\Models\TraineeSessionEquipment;
use App\Http\Requests\StoreTraineeSessionEquipmentRequest;
use App\Http\Requests\UpdateTraineeSessionEquipmentRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class TraineeSessionEquipmentController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(TraineeSessionEquipmentDataTable $dataTable)
    {$trainee_sessions= DB::table('trainee_sessions')->get();$equipment= DB::table('equipment')->get();
                return $dataTable->render('admin.trainee-session-equipment.index',compact('trainee_sessions','equipment',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {$trainee_sessions= DB::table('trainee_sessions')->get();$equipment= DB::table('equipment')->get();
        return view('admin.trainee-session-equipment.new',compact('trainee_sessions','equipment',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTraineeSessionEquipmentRequest $request)
    {

        $trainee_session_equipment = TraineeSessionEquipment::create($request->validated());

        return redirect()->route('admin.trainee-session-equipment.index')->with('success_create', ' trainee_session_equipment added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TraineeSessionEquipment $trainee_session_equipment)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['trainee_session_equipment'] = $trainee_session_equipment;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TraineeSessionEquipment $trainee_session_equipment)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['trainee_session_equipment'] = $trainee_session_equipment;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTraineeSessionEquipmentRequest $request, TraineeSessionEquipment $trainee_session_equipment)
    {

        $trainee_session_equipment->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TraineeSessionEquipment $trainee_session_equipment)
    {
        if (!$trainee_session_equipment->exists()) {
            return redirect()->route('admin.trainee-session-equipment.index')->with('error', 'Unautorized!');
        }
        $trainee_session_equipment->delete();
        return response()->json(array('success' => true), 200);
    }
}

        