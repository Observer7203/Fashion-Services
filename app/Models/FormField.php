<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormField extends Model
{
    protected $fillable = [
        'form_id',
        'label',
        'type',
        'required',
        'options',
        'sort_order',
        'validation_rules',
        'placeholder',
        'default_value',
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array', // Список вариантов (JSON)
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
