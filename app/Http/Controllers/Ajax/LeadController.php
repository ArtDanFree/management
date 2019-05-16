<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class LeadController extends Controller
{
    public $lead;
    public $min;
    public $url;

    public function __construct(Request $request)
    {
        $this->lead = Lead::find($request->lead_id, ['id', 'first_name', 'last_name', 'surname', 'money']);
    }

    public function takeOnCheck()
    {
        $this->update();
        return response()->json(['url' => $this->url]);
    }

    public function update()
    {
        $this->lead->update([
            'underwriter_id' => \Auth::id(),
            'lead_status' => 2
        ]);
        $this->url = Redirect::route('lead.show', $this->lead->id)->getTargetUrl();
        return false;

    }

    public function get()
    {
        return response()->json(['lead' => $this->lead]);
    }
}
