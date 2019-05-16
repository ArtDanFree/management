<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $visible = ['name', 'id'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);

    }
}
