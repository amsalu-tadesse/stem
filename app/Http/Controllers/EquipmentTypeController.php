<?php 
namespace App\Http\Controllers;
use App\DataTables\EquipmentTypeDataTable;
use App\Models\EquipmentType;
use App\Http\Requests\StoreEquipmentTypeRequest;
use App\Http\Requests\UpdateEquipmentTypeRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class EquipmentTypeController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(EquipmentTypeDataTable $dataTable)
    {
            return $dataTable->render('admin.equipment-types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { return view('admin.equipment-types.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentTypeRequest $request)
    {

        $equipment_type = EquipmentType::create($request->validated());

        return redirect()->route('admin.equipment-types.index')->with('success_create', ' equipment_type added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipment_type)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['equipment_type'] = $equipment_type;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentType $equipment_type)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['equipment_type'] = $equipment_type;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentTypeRequest $request, EquipmentType $equipment_type)
    {

        $equipment_type->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentType $equipment_type)
    {
        if (!$equipment_type->exists()) {
            return redirect()->route('admin.equipment-types.index')->with('error', 'Unautorized!');
        }
        $equipment_type->delete();
        return response()->json(array('success' => true), 200);
    }
}

        