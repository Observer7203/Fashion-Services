<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function stages() {
        return $this->hasMany(Stage::class);
    }

    public function reservation()
{
    return $this->belongsTo(\App\Models\Reservation::class);
}
}
