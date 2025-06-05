<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReservationType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'for_tour',
        'for_service',
    ];

    protected $casts = [
        'for_tour' => 'boolean',
        'for_service' => 'boolean',
    ];

    public function stepTemplates(): HasMany
    {
        return $this->hasMany(ReservationStepTemplate::class);
    }
}
