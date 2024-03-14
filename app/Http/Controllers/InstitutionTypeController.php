<?php 
namespace App\Http\Controllers;
use App\DataTables\InstitutionTypeDataTable;
use App\Models\InstitutionType;
use App\Http\Requests\StoreInstitutionTypeRequest;
use App\Http\Requests\UpdateInstitutionTypeRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class InstitutionTypeController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(InstitutionTypeDataTable $dataTable)
    {
            return $dataTable->render('admin.institution-types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { return view('admin.institution-types.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstitutionTypeRequest $request)
    {

        $institution_type = InstitutionType::create($request->validated());

        return redirect()->route('admin.institution-types.index')->with('success_create', ' institution_type added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(InstitutionType $institution_type)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['institution_type'] = $institution_type;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstitutionType $institution_type)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['institution_type'] = $institution_type;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitutionTypeRequest $request, InstitutionType $institution_type)
    {

        $institution_type->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstitutionType $institution_type)
    {
        if (!$institution_type->exists()) {
            return redirect()->route('admin.institution-types.index')->with('error', 'Unautorized!');
        }
        $institution_type->delete();
        return response()->json(array('success' => true), 200);
    }
}

        