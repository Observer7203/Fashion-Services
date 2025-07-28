<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use App\Models\TourPackage;

class TourPackageItem extends Model
{
    use HasTranslations;

    public $translatable = ['content'];

    protected $fillable = ['tour_package_id', 'content'];

    protected $casts = [
        'content' => 'json',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
