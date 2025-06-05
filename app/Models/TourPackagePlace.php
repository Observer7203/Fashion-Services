<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class TourPackagePlace extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['tour_package_id', 'name'];

    protected $casts = [
        'name' => 'json',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
