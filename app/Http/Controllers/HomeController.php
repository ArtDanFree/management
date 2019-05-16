<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use App\Models\Lead;
use App\user_city;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('inside.index');
    }

    public function update(Request $request)
    {
        if (Gate::allows('admin')) {
            $last_leads = Lead::select('created_at')->orderByDesc('created_at')->limit(1)->get();//получение времени последней записи
            //сравнение времени последней записи на сервере и записи, полученной от клиента
            $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                $query->select('id', 'organization');
            }])->where('created_at', '>', $request->time)->orderByDesc('created_at')->get();
        }
        if (Gate::allows('underwriter')) {
            $last_leads = Lead::select('created_at')->orderByDesc('created_at')->limit(1)->get();//получение времени последней записи
            //сравнение времени последней записи на сервере и записи, полученной от клиента
            $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                $query->select('id', 'organization');
            }])->where('created_at', '>', $request->time)->whereIN('city_id', Helper::getCitiesForUnderwriter(\Request::user()->id))->type(\Request::user()->type)->get();
        }
        return response()->json(array('last_leads' => $last_leads, 'leads' => $leads, 'takeOn' => Helper::takeOn(\Request::user()->role_id), 'timezone' => session('timezone')), 200);
    }

    public function select_view(Request $request)
    {
        if (Gate::allows('admin')) {
            if ($request->select != '4') {
                $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                    $query->select('id', 'first_name');
                }])->select($request->select)->orderByDesc('created_at')->paginate(\Request::get('count') ?: 15);
            } else {
                $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                    $query->select('id', 'first_name');
                }])->whereNotIn('city_id', Helper::getUnclaimedLead())->orderByDesc('created_at')->paginate(\Request::get('count') ?: 15);
            }
        }

        if (Gate::allows('underwriter')) {
            $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                $query->select('id', 'first_name');
            }])->select($request->select)->whereIN('city_id', Helper::getCitiesForUnderwriter(\Request::user()->id))->type($request->user()->type)->paginate(\Request::get('count') ?: 15);
        }

        if (Gate::allows('lead')) {
            if ($request->select != '4') {
                $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                    $query->select('id', 'first_name');
                }])->where('user_id', \Request::user()->id)->select($request->select)->orderByDesc('created_at')->paginate(\Request::get('count') ?: 15);
            } else {
                $leads = Lead::with(['status', 'transactionStatus', 'underwriter', 'city', 'user' => function ($query) {
                    $query->select('id', 'first_name');
                }])->where('user_id', \Request::user()->id)->whereNotIn('city_id', Helper::getUnclaimedLead())->orderByDesc('created_at')->paginate(\Request::get('count') ?: 15);
            }
        }

        return response()->json(array('leads' => $leads, 'sel' => Helper::getUnclaimedLead(), 'takeOn' => Helper::takeOn(\Request::user()->role_id), 'timezone' => session('timezone')), 200);
    }
}
