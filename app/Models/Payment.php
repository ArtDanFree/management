<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = true;
    protected $fillable = ['lead_id'];
    protected $guarded = [
        'id',  'created_at', 'updated_at'
    ];

    public function lead ()
    {
        return $this->hasMany(User::class);
    }
}
