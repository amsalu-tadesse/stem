<?php 
namespace App\Http\Controllers;
use App\DataTables\InstitutionDataTable;
use App\Models\Institution;
use App\Http\Requests\StoreInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class InstitutionController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(InstitutionDataTable $dataTable)
    {
            return $dataTable->render('admin.institutions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { return view('admin.institutions.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstitutionRequest $request)
    {

        $institution = Institution::create($request->validated());

        return redirect()->route('admin.institutions.index')->with('success_create', ' institution added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['institution'] = $institution;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['institution'] = $institution;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitutionRequest $request, Institution $institution)
    {

        $institution->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        if (!$institution->exists()) {
            return redirect()->route('admin.institutions.index')->with('error', 'Unautorized!');
        }
        $institution->delete();
        return response()->json(array('success' => true), 200);
    }
}

        