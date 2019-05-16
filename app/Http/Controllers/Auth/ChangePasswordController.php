<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Hash;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        if (Hash::check($request->old_password, $request->user()->password)) {
            User::find($request->user()->id)
                ->update([
                    'password' => Hash::make($request->password)
                ]);
            return \Redirect::route('user.show', \Request::user()->id)->with('message', [__('message.password_changed')]);
        } else {
            return back()->withErrors(__('error.enter_correct_old_password'));
        }
    }

    public function edit($id)
    {
        if ($id != \Auth::user()->id) {
            return back()->with('message', [__('message.no_rights')]);
        } else {
            return view('auth.passwords.edit');
        }
    }
}