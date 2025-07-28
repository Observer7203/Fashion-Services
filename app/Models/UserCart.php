<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Tour;
use App\Models\Service;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'tour_id',
        'package_id',     // ← теперь всегда тут!
        'service_id',
        'quantity',
        'options'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function user()        { return $this->belongsTo(User::class); }
    public function product()     { return $this->belongsTo(Product::class); }
    public function tour()        { return $this->belongsTo(Tour::class); }
    public function service()     { return $this->belongsTo(Service::class); }
    public function package()     { return $this->belongsTo(\App\Models\TourPackage::class, 'package_id'); }
}
