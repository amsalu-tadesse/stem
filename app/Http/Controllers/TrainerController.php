<?php

namespace App\Http\Controllers;

use App\DataTables\TrainerDataTable;
use App\Models\Trainer;
use App\Http\Requests\StoreTrainerRequest;
use App\Http\Requests\UpdateTrainerRequest;
use App\Models\Center;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class TrainerController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(TrainerDataTable $dataTable)
    {
        $centers = Center::all();
        return $dataTable->render('admin.trainers.index',compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centers = Center::all();
        return view('admin.trainers.new',compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainerRequest $request)
    {
        $trainer = Trainer::create($request->validated());
        return redirect()->route('admin.trainers.index')->with('success_create', ' trainer added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainer $trainer)
    {
        if (request()->ajax()) {
            $trainer->load('center:id,name');
            $response = array();
            $response['success'] = 1;
            $response['trainer'] = $trainer;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainer $trainer)
    {
        if (request()->ajax()) {
            $trainer->load('center:id,name');
            $response = array();
            $response['success'] = 1;
            $response['trainer'] = $trainer;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainerRequest $request, Trainer $trainer)
    {

        $trainer->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainer $trainer)
    {
        if (!$trainer->exists()) {
            return redirect()->route('admin.trainers.index')->with('error', 'Unautorized!');
        }
        $trainer->delete();
        return response()->json(array('success' => true), 200);
    }
}
