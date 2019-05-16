<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LeadImage
 *
 * @property int $id
 * @property string $name
 * @property string $img
 * @property int|null $lead_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Lead|null $lead
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LeadImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LeadImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LeadImage whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LeadImage whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LeadImage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LeadImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeadImage extends Model
{
    protected $fillable = ['lead_id', 'name', 'img'];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
