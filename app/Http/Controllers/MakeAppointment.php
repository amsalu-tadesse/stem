<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteAdmin;
use App\Models\Visitor;
use App\Models\InstitutionType;
use App\Models\Institution;
use App\Models\Country;

class MakeAppointment extends Controller
{
    public function index(){
        $visitors = Visitor::all();
        $site_admin = SiteAdmin::first();
        $institution_types = InstitutionType::all();
        $institutions = Institution::all();
        $countries = Country::all();
        return view('admin.make-appointment.make-appointment',compact('institution_types','institutions','countries','visitors'));
    }
}
