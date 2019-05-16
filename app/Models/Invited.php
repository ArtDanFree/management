<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Invited extends Model
{
    protected $guarded = ['id'];
    protected $table = 'invited';

    public function inviter()
    {
        return $this->belongsTo(User::class);
    }

    public function invite()
    {
        return $this->belongsTo(User::class);
    }
}
