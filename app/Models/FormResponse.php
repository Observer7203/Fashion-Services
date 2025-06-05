<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormResponse extends Model
{
    protected $fillable = [
        'form_id',
        'reservation_id',
        'user_id',
        'responses',
    ];

    protected $casts = [
        'responses' => 'array', // Ответы на вопросы в формате [field_id => value]
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
