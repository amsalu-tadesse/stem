<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{

    public function reset()
    {
        return redirect()->route('admin.audit.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $filter_actor = request()->input('actor');
        $filter_subject = request()->input('subject');
        $filter_action = request()->input('action');
        $filter_dateRange = request()->input('dateRange');
        $dateRangeArray = explode(' - ', $filter_dateRange);

        // dd( $dateRangeArray);

        $datas = [];
        $audits = [];
        $subjects = [];
        $actions = [];
        $actors = [];


        $allData = Activity::all();
        $datas = Activity::latest();



            if ($filter_actor) {
                $datas->where('causer_id', $filter_actor);
            }

            if ($filter_subject) {
                $datas->where('subject_type', 'App\Models\\' . $filter_subject);
            }
            if ($filter_action) {
                $datas->where('event',  $filter_action);
            }
            if ($filter_dateRange) {
                $startDate= $dateRangeArray[0];
                $endDate= $dateRangeArray[1];
                $datas->whereBetween('created_at', [$startDate, $endDate]);
            }

            $datas = $datas->get();



        foreach ($allData as $dat) {
            $clss_name = explode('\\', $dat->subject_type)[2];
            $subjects[$clss_name] = $clss_name;
            $actions[$dat->event] = $dat->event;
            if ($dat?->causer?->id) {
                $actors[$dat?->causer?->id] = $dat->causer;
            }
        }


        foreach ($datas as $activity0) {

            $subject = $activity0->subject;
           /* if (!$subject) {

                $activity = Activity::where('subject_type', '=', $activity0->subject_type)
                    ->where('subject_id', '=', $activity0->subject_id)
                    ->where('description', '=', 'deleted')
                    ->latest()
                    ->first();

                if ($activity) {

                    $subject_type = $activity->subject_type::where('id', $activity->subject_id)->first();
                    // dd($subject4);
                    $audits[] = array(
                        'subject_type' => class_basename($subject_type),
                        'subject_name' => $this->getSubjecName($subject_type),
                        'actor_name' => $activity->causer->first_name,
                        'activity' => $activity->description,
                        'properties' => $activity->properties,
                        'created_at' => $activity->created_at,
                    );
                }
            } else //for non deleted activities*/
            {
                $audits[] = array(
                    'subject_type' => class_basename($subject),
                    'subject_name' => $this->getSubjecName($subject),
                    'actor_name' => $activity0?->causer?->first_name,
                    'activity' => $activity0->description,
                    'created_at' => $activity0->created_at,
                    'properties' => $activity0->properties,

                );


            }

        }



// dd($audits);
        return view('admin.audit.audit', [
            'audits' => $audits,
            'actors' => $actors,
            'subjects' => $subjects,
            'actions' => $actions,
            'filter_actor' => $filter_actor,
            'filter_subject' => $filter_subject,
            'filter_action' => $filter_action,
            'filter_dateRange' => $filter_dateRange,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSubjecName($model)
    {
        $modelName = class_basename($model);

        $message = match ($modelName) {
            "Organization", "OrganizationType", "OrganizationLevel", "Region", "Zone", "Kpi", "WorkingGroup" => $model->name,
            "User" => $model->first_name . " " . $model->middle_name,
            "Issue" => $model->title,
            "Email" => $model->subject,
            default => 'Unknown',
        };
        return $message;
    }
}
