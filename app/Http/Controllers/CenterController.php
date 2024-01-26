<?php

namespace App\Http\Controllers;

use App\DataTables\CenterDataTable;
use App\Models\Center;
use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest;
use App\Models\User;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\DB;


class CenterController extends Controller
{
    use ModelAuthorizable;
    /**
     * Display a listing of the resource.
     */
    public function index(CenterDataTable $dataTable)
    {
        return $dataTable->render('admin.centers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.centers.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCenterRequest $request)
    {

        $center = Center::create($request->validated());

        return redirect()->route('admin.centers.index')->with('success_create', ' center added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['center'] = $center;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center)
    {
        if (request()->ajax()) {
            $response = array();
            $response['success'] = 1;
            $response['center'] = $center;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCenterRequest $request, Center $center)
    {

        $center->update($request->validated());

        return response()->json(array('success' => true), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Center $center)
    {
        if (!$center->exists()) {
            return redirect()->route('admin.centers.index')->with('error', 'Unautorized!');
        }
        $center->delete();
        return response()->json(array('success' => true), 200);
    }
}
