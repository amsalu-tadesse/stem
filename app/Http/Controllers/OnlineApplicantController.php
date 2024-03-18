<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteAdmin;
use App\Rules\MobileNumber;
use App\Models\OnlineApplication;
use Illuminate\Support\Facades\Storage;



class OnlineApplicantController extends Controller
{
    public function index(){
        $site_admin = SiteAdmin::first();

        return view("online-applicant",compact('site_admin'));
    }

    public function store(Request $request){

        $request->validate([
            "applicant_name" => "required",
            'applicant_phone_number' => ['required', new MobileNumber],
            "research_title" => "required",
            "statement_of_problem" => "required",
            "total_cost" => "required",
            "project_duration" => "required|numeric|min:1",
            "file_attachement" => "required|file|mimes:jpeg,png,gif,pdf,doc,docx",
        ]);

        // Handle file upload
        if ($request->hasFile('file_attachement')) {
            // Get the file
            $file = $request->file('file_attachement');
            $filePath = $file->store('attachments');
        }

        $formData = [
            "applicant_name" => $request->input('applicant_name'),
            "applicant_phone_number" => $request->input('applicant_phone_number'),
            "research_title" => $request->input('research_title'),
            "statement_of_problem" => $request->input('statement_of_problem'),
            "total_cost" => $request->input('total_cost'),
            "project_duration" => $request->input('project_duration'),
            "file_attachement" => $filePath, // Store file path in database
        ];

        OnlineApplication::create($formData);
        return response()->json(['message' => 'Information sent successfully'], 200);
    }

    public function applicantList(){
        $applicant_list = OnlineApplication::orderBy('created_at', 'desc')->get();
        return view('admin.applicant.index', compact('applicant_list'));
    }


    public function downloadAttachment($id)
    {
        $applicant = OnlineApplication::findOrFail($id);
        $filePath = $applicant->file_attachement;
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

}
