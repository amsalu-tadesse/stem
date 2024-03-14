<?php 
namespace App\Http\Controllers;
use App\DataTables\FundTypeDataTable;
use App\Models\FundType;
use App\Http\Requests\StoreFundTypeRequest;
use App\Http\Requests\UpdateFundTypeRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class FundTypeController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(FundTypeDataTable $dataTable)
    {
            return $dataTable->render('admin.fund-types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { return view('admin.fund-types.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundTypeRequest $request)
    {

        $fund_type = FundType::create($request->validated());

        return redirect()->route('admin.fund-types.index')->with('success_create', ' fund_type added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FundType $fund_type)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['fund_type'] = $fund_type;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundType $fund_type)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['fund_type'] = $fund_type;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundTypeRequest $request, FundType $fund_type)
    {

        $fund_type->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundType $fund_type)
    {
        if (!$fund_type->exists()) {
            return redirect()->route('admin.fund-types.index')->with('error', 'Unautorized!');
        }
        $fund_type->delete();
        return response()->json(array('success' => true), 200);
    }
}

        