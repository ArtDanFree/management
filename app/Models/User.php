<?php

namespace App\Models;


use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = ['first_name', 'last_name', 'surname', 'id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function lead ()
    {
        return $this->hasMany(Lead::class);
    }
    public function underwriter ()
    {
        return $this->hasMany(Lead::class, 'underwriter_id');
    }

    
    public function payment ()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Checks if User has access to $permissions.
     */
    public function hasAccess(array $permissions) : bool
    {
            if($this->role->hasAccess($permissions)) {
                return true;
            }
        return false;
    }
    public function notification()
    {
        return $this->belongsToMany(Notification::class)->withPivot('confirmed');
    }

    public function city()
    {
        return $this->belongsToMany(City::class, 'user_cities');
    }

    public function inviter()
    {
        return $this->hasMany(Invited::class, 'inviter_id');
    }

    public function invite()
    {
        return $this->hasMany(Invited::class, 'invite_id');
    }

    public function sendPasswordResetNotification($token)
    {
        \Mail::to(\Request::all()['email'])->queue(new \App\Mail\ResetPassword($token));
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

}
