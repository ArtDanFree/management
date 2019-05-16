<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\City;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Helper;
use Carbon;

class UserController extends Controller
{
    public function show($id)
    {
        if (\Request::user()->id == $id or \Auth::user()->role->name == 'Администратор') {
          $time = Carbon\Carbon::now();
            return view('inside.user.show', ['user' => User::find($id),'time'=>$time]);
        }
        return back()->with('message', [__('message.no_rights')]);

    }

    public function edit($id)
    {
        if (\Request::user()->id == $id) {
            $user = User::with('notification')->find($id);
            return view('inside.user.edit', compact(['user']));
        }
        return back()->with('message', [__('message.no_rights')]);

    }

    public function update(UserUpdateRequest $request, $id)
    {
      if (\Request::user()->id == $id) {
        $users = User::find($id);
        UserHistory::create(Helper::getUpdateData($request, $users));
        $users->update($request->all());
        return \Redirect::route('user.show', \Request::user()->id)->with('message', [__('message.data_changed')]);

      }
      return back()->with('message', [__('message.no_rights')]);

    }

    public function citiesList($id)
    {
        if (\Request::user()->id == $id) {
            $user_city = City::select('name','id')->whereIN('id',  Helper::getCitiesForUnderwriter($id) )->orderBy('name','desc')->get();
            return view('inside.user.cities_list', compact(['user_city']));
      }
      return back()->with('message', [__('message.no_rights')]);
    }
}
