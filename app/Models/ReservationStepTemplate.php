<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationStepTemplate extends Model
{
    protected $fillable = [
        'reservation_type_id',
        'step_key',
        'title',
        'description',
        'order',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ReservationType::class, 'reservation_type_id');
    }
}
