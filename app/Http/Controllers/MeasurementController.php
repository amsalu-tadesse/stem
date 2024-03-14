<?php 
namespace App\Http\Controllers;
use App\DataTables\MeasurementDataTable;
use App\Models\Measurement;
use App\Http\Requests\StoreMeasurementRequest;
use App\Http\Requests\UpdateMeasurementRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class MeasurementController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(MeasurementDataTable $dataTable)
    {
            return $dataTable->render('admin.measurements.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { return view('admin.measurements.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeasurementRequest $request)
    {

        $measurement = Measurement::create($request->validated());

        return redirect()->route('admin.measurements.index')->with('success_create', ' measurement added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Measurement $measurement)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['measurement'] = $measurement;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Measurement $measurement)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['measurement'] = $measurement;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeasurementRequest $request, Measurement $measurement)
    {

        $measurement->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurement $measurement)
    {
        if (!$measurement->exists()) {
            return redirect()->route('admin.measurements.index')->with('error', 'Unautorized!');
        }
        $measurement->delete();
        return response()->json(array('success' => true), 200);
    }
}

        