<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'status',
        'notes',
        'completed_at',
    ];

    protected $dates = ['completed_at'];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
