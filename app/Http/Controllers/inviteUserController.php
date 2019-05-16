<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteUserRequest;
use App\Mail\InviteUser;
use Illuminate\Http\Request;
use Mail;

class inviteUserController extends Controller
{
    public function invite(InviteUserRequest $request)
    {
        if (\Gate::denies('invite-user')) {
            return back()->with('message', [__('message.no_rights')]);
        }

        $code = str_random(100);
        $this->create($request, $code);
        $this->mail($request, $code);
        return back()->with('message', [__('message.sent_message')]);
    }

    public function create(Request $request, $code)
    {
        \App\Models\Invited::updateOrCreate(['email' => $request->email], [
            'inviter_id' => $request->user()->id,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'code' => $code,
            'role' => $request->collateral

        ]);
    }

    public function mail($request, $code)
    {
        Mail::to($request->email)->queue(new InviteUser($request->all(), $code));
    }
}
