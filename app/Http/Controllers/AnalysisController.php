<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use App\Models\OrganizationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AnalysisController extends Controller
{



    public function visualize()
    {
        // dd(auth()->user()->can('faq-list'));
        $allkpis = request()->input('allkpis');
        $kpis = $allkpis ? Kpi::all() : Kpi::where('id', '>=', 4)->get();
        $data = [];
        $selectLevel = request()->input('level');
        $levels = OrganizationLevel::all();

        foreach ($kpis as $kpi) {
            $c = count($kpi->issues);
            if (!$c) continue;

            $count = $selectLevel
                ? $kpi->issues->where('issue_level', $selectLevel)->count()
                : $kpi->issues->count();

            $data[] = [
                'issue' => $kpi->name,
                'count' => $count,
            ];
        }

        return view('admin.analysis.index', [
            'data' => $data,
            'levels' => $levels,
            'selectLevel' => $selectLevel,
            'allkpis' => $allkpis,
        ]);
    }
}
