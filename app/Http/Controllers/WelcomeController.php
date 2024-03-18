<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitorRequest;
use App\Models\SiteAdmin;
use App\Models\Visitor;
use App\Models\InstitutionType;
use App\Models\Institution;
use App\Models\Country;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitors = Visitor::all();

        $site_admin = SiteAdmin::first();
        $institution_types = InstitutionType::all();
        $institutions = Institution::all();
        $countries = Country::all();


        return view('welcome', compact('visitors', 'site_admin','institution_types','institutions','countries'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitorRequest $request)
    {
        Visitor::create($request->validated());

        return response()->json(array("success" => true), 200);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
