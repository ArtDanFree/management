<?php

namespace App\Http\Controllers\Auth;

use App\Models\Invited;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'code' => 'required|string|exists:invited,code'
        ]);
    }

    public function ifInvited($data)
    {
        return Invited::where('code', $data['code'])
            ->where('email', $data['email'])
            ->first();
    }

    protected function create(array $data)
    {
        $invited = $this->ifInvited($data);
        if (!$invited) {
            return die();
        }

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $invited->role
        ]);

        $this->updateInviteUser($invited->id, $user);

        return $user;
    }

    public function updateInviteUser($id, $user)
    {
        Invited::find($id)
            ->update([
                'code' => null,
                'invite_id' => $user->id
            ]);
    }
}
