<?php

namespace App\Http\Controllers\Ajax;

use App\Helpers\Helper;
use App\Http\Controllers\Filtres\HomeLeadsFilterController;
use App\Models\Lead;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $builder = $this->role();
        $filter = (new HomeLeadsFilterController($builder, $request))->apply()->paginate(\Request::get('count') ?: 15);
        $result = $this->transform($filter);
        return response()->json($result);

    }

    public function role()
    {
        if (Gate::allows('lead')) {
            return $this->lead();
        }
        elseif (Gate::allows('admin')) {
            return $this->admin();
        }
        elseif (Gate::allows('underwriter')) {
            return $this->underwriter();
        }
    }

    public function lead()
    {
        return Lead::with(['status', 'transactionStatus', 'city', 'typeDeposit'])
            ->where('user_id', \Request::user()->id);
    }

    public function underwriter()
    {
        $minutes = \Auth::user()->fine ? Carbon::now()->addMinutes(\Auth::user()->fine->level) : Carbon::now();
        return Lead::with(['status', 'transactionStatus', 'city', 'typeDeposit'])
            ->where('created_at', '<', $minutes)
            ->where(function ($q) {
                $q->whereIn('city_id', Helper::getCitiesForUnderwriter(\Request::user()->id))->type(\Auth::user()->type)
                    ->where('lead_status', 1)
                ->whereNull('underwriter_id');
            })
            ->orWhere('underwriter_id', \Auth::id());
    }

    public function admin()
    {
        return Lead::with(['status', 'transactionStatus', 'user', 'underwriter', 'city.underwriter', 'typeDeposit']);
    }

    public function transform($leads)
    {
        $leads->getCollection()->transform(function ($lead) {
            $lead->timezone = $lead->created_at->timezone(session('timezone'))->format('d.m.Y H:i:s') ?: 'Пусто';
            return $lead;
        });
        return $leads;
    }
}
