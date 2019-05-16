<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use App\Models\City;
use App\Models\user_city;
use App\Models\UserHistory;
use DB;
use Helper;
use Auth;
use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{

    public function index()
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', [__('message.no_rights')]);
        }

        $users = User::with('role')->get();
        $cities = City::all();
        $roles = Role::all();
        return view('inside.admin.index', compact(['users', 'cities', 'roles']));

    }

    public function indexCustom($type)
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', [__('message.no_rights')]);
        }

        $users = User::with('role')->where('role_id', $type)->get();
        $cities = City::all();
        $roles = Role::all();
        return view('inside.admin.index', compact(['users', 'cities', 'roles', 'type']));

    }

    public function searchByCities($city)
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', [__('message.no_rights')]);
        }
        $cities = City::all();
        $users = User::with('role')->whereIN('id', Helper::getUserByCity($city))->get();
        $roles = Role::all();
        return view('inside.admin.index', compact(['users', 'cities', 'roles', 'type']));
    }

    public function adminSearchName(Request $request)
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', ['У вас нет прав']);
        }
        $cities = City::all();
        $users = User::with('role')->orWhere('first_name', 'like', '%' . $request->search_name . '%')->orWhere('last_name', 'like', '%' . $request->search_name . '%')->orWhere('surname', 'like', '%' . $request->search_name . '%')->get();
        $roles = Role::all();
        return view('inside.admin.index', compact(['users', 'cities', 'roles']));

    }

    public function edit($id)
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', [__('message.no_rights')]);
        }
        return view('inside.admin.edit_user', [
            'user' => User::find($id),
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, $user)
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', [__('message.no_rights')]);
        }
        $user = User::where('id', $user)->first();
        UserHistory::create([
            'user_id' => $user->id,
            'editor_id' => Auth::id(),
            'commission' => $user->commission
        ]);

        $user->commission = $request->commission;
        $user->save();

        return back()->with('message', [__('message.data_updated')]);
    }

    public function updateRole(Request $request, $id)
    {
        if (\Gate::denies('change-role')) {
            return back()->with('message', [__('message.no_rights')]);
        }
        $user = User::where('id', $id)->first();
        UserHistory::create([
            'user_id' => $id,
            'editor_id' => Auth::id(),
            'role_id' => $user->role_id
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return back()->with('message', [__('message.data_updated')]);
    }

    public function showLeads($id)
    {
        $leads = Lead::whereUserId($id)->paginate(\Request::get('count') ?: 15);
        return view('inside.admin.leads.index', compact(['leads', 'id']));
    }

    public function update_type(Request $request)
    {
        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        $user = User::where('id', $request->id)->first();
        UserHistory::create([
            'user_id' => $request->id,
            'editor_id' => Auth::id(),
            'type' => $user->type
        ]);
        $user->type = $request->type;
        $user->save();
    }

    public function update_cities(Request $request)
    {

        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        $tmp = Helper::getCitiesForHistory($request->user);
        UserHistory::create([
            'user_id' => $request->user,
            'editor_id' => Auth::id(),
            'cities' => $tmp
        ]);
        $delete_cities = user_city::with('City')->where('user_id', $request->user);
        $delete_cities->delete();

        Helper::saveUnderwriterCity($request);
        return response()->json(array('request' => $request), 200);
    }

    public function get_user_cities(Request $request)
    {
        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        $user_city = City::select('name', 'id')->whereIN('id', Helper::getCitiesForUnderwriter($request->user))->orderBy('name', 'desc')->get();
        return response()->json(array('user_city' => $user_city, 'user_id' => $request->user), 200);
    }

    public function admin_add_cities()
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', ['У вас нет прав']);
        }
        $cities = City::select('name', 'id')->where('id', '<>', '1')->orderBy('name')->get();
        return view('inside.admin.admin_add_cities', compact(['cities']));
    }

    public function change_city_name(Request $request)
    {
        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        $cities = City::where('id', $request->id)->first();
        $cities->name = $request->name;
        $cities->save();
        $city = City::select('name', 'id')->where('id', '<>', '1')->orderBy('name', 'desc')->get();
        return response()->json(array('message' => 'ok', 'city' => $city), 200);
    }

    public function add_new_city(Request $request)
    {
        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        $city = City::create([
            'name' => $request->name,
        ]);
        $city = City::select('name', 'id')->where('id', '<>', '1')->orderBy('name', 'desc')->get();
        return response()->json(array('message' => 'ok', 'city' => $city), 200);
    }

    public function check_city(Request $request)
    {

        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        $check = Lead::where('city_id', $request->id)->where('id', '<>', '1')->get();
        return response()->json(array('message' => 'ok', 'check' => $check), 200);
    }

    public function delete_city(Request $request)
    {

        if (\Gate::denies('admin')) {
            return response()->json(array('error' => 'Недостаточно прав'), 200);
        }

        Helper::deleteCity($request);
        return response()->json(array('message' => 'ok'), 200);
    }

    public function history($id)
    {
        if (\Gate::denies('admin')) {
            return back()->with('message', [__('message.no_rights')]);
        }
        $history = UserHistory::with('user', 'role')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('inside.reports.history', compact(['history', 'id']));
    }
}
