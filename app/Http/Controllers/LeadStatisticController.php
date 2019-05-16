<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeadStatisticController extends Controller
{

    public function __invoke(Request $request, $id)
    {
        $s = new StatisticController();
        $statistics = $s->leadGeneratorMonthly($id);

        return view('inside.admin.leads.statistic', compact(['statistics', 'id']));
    }

}
