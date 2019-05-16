<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadStatusUpdateRequest;
use App\Models\Lead;
use App\Models\LeadRejectionReason;
use App\Models\LeadStatus;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\Redirect;
use Helper;

class   LeadController extends Controller
{
    public function index()
    {
        return abort(404);
    }

    public function store(LeadStoreRequest $request)
    {
        $lead = Lead::create([
            'phone' => $request->phone,
            'city_id' => $request->city_id,
            'type' => $request->collateral,
            'user_id' => \Request::user()->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'surname' => $request->surname,
            'money' => $request->money,
        ]);

        return Redirect::route('lead.show', $lead->id)->with('message', [__('message.lead_add')]);
    }
//TODO put in middleware
    public function show($id)
    {
        $lead = Lead::find($id);
        if (empty($lead->user_id)) {
            return back()->with('message', [__('message.lead_no_exist')]);
        }
        if ($lead->user_id == \Request::user()->id or \Gate::allows('admin') or $lead->underwriter_id == \Auth::id()) {
            return view('inside.lead.show', [
                'lead' => $lead,
                'documents' => $lead->leadImage,
                'transactionStatus' => TransactionStatus::all(),
                'leadStatus' => LeadStatus::all(),
                'rejectionReason' => LeadRejectionReason::all()
            ]);
        }
        if ($lead->underwriter_id != \Auth::id()) {
            return back()->with('message', [__('message.take_lead_to_check')]);
        }

        return back()->with('message', [__('message.no_rights')]);

    }

    public function edit($id)
    {
        $lead = Lead::find($id);
        if ($lead->user_id == \Request::user()->id or (\Gate::allows('update-lead-phone') and (Helper::getAccessType(\Request::user()->type, $lead->type) == 1)) and (Helper::getAccessCity(\Request::user()->id, $lead->city_id) != 0)) {
            return view('inside.lead.edit', compact('lead'));
        }
        return back()->with('message', [__('message.no_rights')]);

    }

    public function update(LeadStatusUpdateRequest $request, $id)
    {
        $lead = Lead::find($id);
        if ($lead->user_id == \Request::user()->id or \Gate::allows('update-lead-phone') or \Gate::allows('admin')) {
            $lead->update($request->all());

            if ($request->transaction_status != 3) {
                $lead->total_amount = null;
            }
            if ($request->lead_status == 4) {
                $lead->transaction_status = '4';
            }
            $lead->save();

            return back()->with('message', [__('message.data_changed')]);
        }
        return back()->with('message', [__('message.no_rights')]);
    }
}
