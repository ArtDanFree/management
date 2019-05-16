<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Lead
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $full_name
 * @property string $money
 * @property string $phone
 * @property int $status
 * @property string|null $check
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LeadImage[] $leadImage
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Lead whereUserId($value)
 * @mixin \Eloquent
 */
class Lead extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['phone', 'user_id', 'underwriter_id', 'city_id'];

    public function leadImage()
    {
        return $this->hasMany(LeadImage::class);
    }

    public function status()
    {
        return $this->hasOne(LeadStatus::class, 'id', 'lead_status');
    }

    public function transactionStatus()
    {
        return $this->hasOne(TransactionStatus::class, 'id', 'transaction_status');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function underwriter()
    {
        return $this->belongsTo(User::class);
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeType($query, $type)
    {
        if ($type == 3) {
            return $query->orderByDesc('created_at');
        } else {
            return $query->orderByDesc('created_at')->where('type', \Request::user()->type);
        }
    }

    public function scopeSelect($query, $sel)
    {
        switch ($sel) {
            case 2:
                return $query->whereNull('underwriter_id');
                break;
            case 3:
                return $query->where('underwriter_id', \Request::user()->id);
                break;
        }
    }

    public function typeDeposit()
    {
        return $this->hasOne(TypeDeposit::class, 'id', 'type');
    }

    public static function monthly($id)
    {
        $leads = Lead::where('user_id', $id)
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y.m');
            })
            ->sortKeysDesc();

        return $leads;
    }

}
