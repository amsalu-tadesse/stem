<?php

namespace App\Http\Controllers;

use App\DataTables\TraineeDataTable;
use App\Models\Trainee;
use App\Http\Requests\StoreTraineeRequest;
use App\Http\Requests\UpdateTraineeRequest;
use App\Models\Center;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class TraineeController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(TraineeDataTable $dataTable)
    {
        $centers = Center::all();
        return $dataTable->render('admin.trainees.index', compact('centers',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = Center::all();
        return view('admin.trainees.new', compact('centers',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTraineeRequest $request)
    {
        $trainee = Trainee::create($request->validated());
        return redirect()->route('admin.trainees.index')->with('success_create', ' trainee added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainee $trainee)
    {
        if (request()->ajax()) {
            $trainee->load('center:id,name');
            $response = array();
            $response['success'] = 1;
            $response['trainee'] = $trainee;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainee $trainee)
    {
        if (request()->ajax()) {
            $trainee->load('center:id,name');
            $response = array();
            $response['success'] = 1;
            $response['trainee'] = $trainee;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTraineeRequest $request, Trainee $trainee)
    {

        $trainee->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainee $trainee)
    {
        if (!$trainee->exists()) {
            return redirect()->route('admin.trainees.index')->with('error', 'Unautorized!');
        }
        $trainee->delete();
        return response()->json(array('success' => true), 200);
    }
}
