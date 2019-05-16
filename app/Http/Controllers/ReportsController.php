<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Payment;
use Storage;
use Auth;
use Illuminate\Http\Request;


class ReportsController extends Controller
{
    public function index()
    {
        if (\Gate::allows('show-all-leads')) {

            $leads = Lead::with(['user'])->get();
            Helper::getCommission($leads);

            $leads = $leads->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y.m');
            })->sortKeysDesc();

            return view('inside.reports.index', compact('leads'));
        }

        if (\Gate::allows('show-own-leads')) {
            $leads = Lead::where('user_id', \Request::user()->id)->get()->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y.m');
            })->sortKeysDesc();
            return view('inside.reports.index', compact('leads'));
        }

    }

    public function month($data)
    {
        if (\Gate::allows('show-all-leads')) {
            $date = str_replace('.', '-', $data) . '%';
            $leads = Lead::with(['user', 'city', 'transactionStatus', 'status'])->where('created_at', 'like', $date)->paginate(\Request::get('count') ?: 15);
            return view('inside.reports.month', [
                'leads' => $leads,
                'data' => $data
            ]);
        }
        if (\Gate::allows('show-own-leads')) {
            $date = str_replace('.', '-', $data) . '%';
            $leads = Lead::where('created_at', 'like', $date)->where('user_id', \Request::user()->id)->paginate(\Request::get('count') ?: 15);
            return view('inside.reports.month', [
                'leads' => $leads,
                'data' => $data,
                'document' => Helper::getTicket($data)
            ]);
        }
    }

    public function underwriterTakeOnCheckLeads($id)
    {
        $leads = Lead::with('underwriter')->where('underwriter_id', $id)->paginate(\Request::get('count') ?: 15);
        return view('inside.reports.underwriter_report_taken_on_check_leads', compact(['leads', 'id']));
    }

    public function underwriterReportInviteLeads($id)
    {
        $user = User::with(['invite', 'inviter'])->find($id);

        return view('inside.reports.underwriter_report_invite_leads', compact(['user', 'id']));
    }

//данные об оплатах
    public function pay(Request $request, $data)
    {
        $date = str_replace('.', '-', $data);
        $date1 = str_replace('.', '-', $data) . '%';
        $users = User::with(['lead', 'payment'])->get();
        $leads = Lead::where('created_at', 'like', $date1)->get();

        return view('inside.reports.pay', [
            'users' => $users,
            'leads' => $leads,
            'payment' => payment::all(),
            'date' => $date,
            'date1' => $date1,
        ]);
    }

//загрузка квитанции и добавление данных оплаты в таблицу payments
    public function payment(Request $request, $dat)
    {

        if (\Gate::allows('admin')) {
            if ($request->isMethod('post') && $request->file('file')) {
                Helper::saveReport($request, $dat);
                return redirect()->back();
            } else {
                return back()->with('message', [__('message.document_not_attached')]);
            }
            return redirect()->back();
        }
    }

    public function delete(Request $request, $date, $id)
    {
        if (\Gate::allows('admin')) {
            Helper::deleteReport($request, $date, $id);
        }
        return redirect()->back();

    }

    public function leadgen_details(Request $request, $data, $id)
    {


        if (\Gate::allows('show-all-leads')) {
            $date = str_replace('.', '-', $data) . '%';
            $leads = Lead::where('created_at', 'like', $date)->where('user_id', $id)->paginate(\Request::get('count') ?: 15);
            return view('inside.reports.leadgen_details', [
                'leads' => $leads,
                'data' => $data,

            ]);
        }
    }
}
