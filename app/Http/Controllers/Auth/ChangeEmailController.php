<?php

namespace App\Http\Controllers\Auth;

use App\Models\ChangeEmail;
use App\Mail\NewEmail;
use App\Mail\OldEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangeEmailController extends Controller
{
    public function changeEmail(Request $request)
    {
        $this->changeEmailRules($request);
        $data = $this->create($request);
        \Mail::to($data->old_email)->queue(new OldEmail($data->old_email_code));

        return back()->with('message', ['На почту ' . $data->old_email . ' отправлено письмо']);
    }

    public function create($request)
    {
        return ChangeEmail::create([
            'user_id' => \Auth::user()->id,
            'old_email' => \Auth::user()->email,
            'old_email_code' => str_random(100),
            'new_email' => $request->new_email
        ]);
    }

    public function changeEmailRules($request)
    {
        return $this->validate($request, [
            'new_email' => 'required|string|min:6|confirmed'
        ]);
    }

    public function confirmChangeEmail($code)
    {
        $data = ChangeEmail::where('old_email_code', $code)->first();

        if ($data) {
            $this->update($data);
            \Mail::to($data->new_email)->queue(new NewEmail($data->new_email_code));

            return \Redirect::route('home')->with('message', ['На почту ' . $data->new_email . ' отправлено письмо']);
        } else {
            return \Redirect::route('home')->withErrors(__('message.invalid_code'));
        }
    }

    public function saveNewEmail($code)
    {
        $data = ChangeEmail::where('new_email_code', $code)->first();

        if ($data) {
            $data->update([
                'new_email_code' => null
            ]);
            User::where('email', $data->old_email)->first()->update([
                'email' => $data->new_email,
            ]);

            return \Redirect::route('home')->with('message', [__('message.you_changed_mail')]);
        } else {
            return \Redirect::route('home')->withErrors(__('error.invalid_code'));
        }
    }

    public function update($data)
    {
        return $data->update([
            'new_email_code' => str_random(100),
            'old_email_code' => null
        ]);
    }

    public function edit($id)
    {
        if ($id != \Auth::user()->id) {
            return back()->with('message', [__('message.no_rights')]);
        } else {
            return view('auth.email.edit');
        }
    }
}
