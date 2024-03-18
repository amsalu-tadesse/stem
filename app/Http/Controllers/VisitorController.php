<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Http\Requests\StoreVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use App\Traits\ModelAuthorizable;
use App\DataTables\VisitorDataTable;
use App\Constants\Constants;

class VisitorController extends Controller
{
    // use ModelAuthorizable;

    /**
     * Display a listing of the resource.
     */
    public function index(VisitorDataTable $dataTable)
    {
        return $dataTable->render('admin.visitors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitorRequest $request)
    {
        $visitors = Visitor::where('appointment_date', $request->appointment_date);
        $entries = $visitors->where('visiting_hr', $request->visiting_hr)->count();
        $date_entries = $visitors->whereIn('visiting_hr', ['2-4', '4-6', '7-9', '9-11'])->count();

        //check for past date appointment
        if ($request->appointment_date < now()->format('Y-m-d')) {
            return response()->json(['success' => false], 200);
        }

        //check for appointment time range repetition
        if ($entries > 0 || $date_entries >= 4) {
            return response()->json(['success' => false], 200);
        }
        $visitor = Visitor::create($request->validated());
        if ($visitor->created_from) {
            $visitor->created_from = 'Inside';
            $visitor->save();
        } else {
            $visitor->created_from = 'Outside';
            $visitor->save();
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitor $visitor)
    {
        if (request()->ajax()) {
            $visitor->load('institution:id,name')->load('institutionType:id,name')->load('country:id,name');
            $response = [];
            $response['success'] = 1;
            $response['visitor'] = $visitor;
            return response()->json($response);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        if (request()->ajax()) {
            $response = [];
            $response['success'] = 1;
            $response['visitor'] = $visitor;
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitorRequest $request, Visitor $visitor)
    {
        $visitor->update($request->validated());
        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        if (!$visitor->exists()) {
            return redirect()->route('admin.visitors.index')->with('error', 'Unautorized!');
        }
        $visitor->delete();
        return response()->json(['success' => true], 200);
    }
}
