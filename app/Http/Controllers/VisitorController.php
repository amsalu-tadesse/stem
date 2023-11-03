<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Http\Requests\StoreVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use App\Traits\ModelAuthorizable;


class VisitorController extends Controller
{
    // use ModelAuthorizable;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.visitors.index');
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
        $visitor = Visitor::where('appointment_date', $request->appointment_date);
        $entries = $visitor->where('visiting_hr', $request->visiting_hr)->count();
        $date_entries =$visitor->whereIn('visiting_hr', ['2-4', '4-6', '7-9', '9-11'])->count();

        if ($request->appointmnet_date < now()->format('Y-m-d')) {
            return response()->json(array("success" => false), 200);
        }

        if ($entries > 0 || $date_entries >= 4) {
            return response()->json(array("success" => false), 200);

        }
         else {
            Visitor::create($request->validated());

            return response()->json(array("success" => true), 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitorRequest $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}
