<?php 
namespace App\Http\Controllers;
use App\DataTables\TraineeGroupDataTable;
use App\Models\TraineeGroup;
use App\Http\Requests\StoreTraineeGroupRequest;
use App\Http\Requests\UpdateTraineeGroupRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class TraineeGroupController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(TraineeGroupDataTable $dataTable)
    {$groups= DB::table('groups')->get();$trainees= DB::table('trainees')->get();
                return $dataTable->render('admin.trainee-groups.index',compact('groups','trainees',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {$groups= DB::table('groups')->get();$trainees= DB::table('trainees')->get();
        return view('admin.trainee-groups.new',compact('groups','trainees',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTraineeGroupRequest $request)
    {

        $trainee_group = TraineeGroup::create($request->validated());

        return redirect()->route('admin.trainee-groups.index')->with('success_create', ' trainee_group added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TraineeGroup $trainee_group)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['trainee_group'] = $trainee_group;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TraineeGroup $trainee_group)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['trainee_group'] = $trainee_group;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTraineeGroupRequest $request, TraineeGroup $trainee_group)
    {

        $trainee_group->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TraineeGroup $trainee_group)
    {
        if (!$trainee_group->exists()) {
            return redirect()->route('admin.trainee-groups.index')->with('error', 'Unautorized!');
        }
        $trainee_group->delete();
        return response()->json(array('success' => true), 200);
    }
}

        