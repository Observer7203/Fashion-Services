<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'item_id',
        'title',
        'price',
        'quantity',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
