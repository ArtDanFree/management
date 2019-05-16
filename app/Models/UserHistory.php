<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $table = 'users_history';
    protected $fillable = ['user_id','first_name','last_name', 'surname','organization','credit_card_number','personal_acc','correspondent_acc','bic_bank','name_bank','type','cities','telegram','commission','role_id', 'editor_id'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function editor ()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
