<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ReservationStepTemplate;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'tour_id',
        'service_id',
        'reservation_type_id',
        'tour_package_id',
        'status',
        'progress_percent',
        'admin_notes',
    ];

    // ====== BOOT: автосоздание шагов из шаблонов ======
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reservation) {
            $templates = ReservationStepTemplate::where('reservation_type_id', $reservation->reservation_type_id)
                ->orderBy('order')
                ->get();

            foreach ($templates as $template) {
                $reservation->steps()->create([
                    'step_key'    => $template->step_key,
                    'title'       => $template->title,
                    'description' => $template->description,
                    'order'       => $template->order,
                ]);
            }
        });
    }

    // Отношения
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function reservationType(): BelongsTo
    {
        return $this->belongsTo(ReservationType::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(ReservationStep::class)->orderBy('order');
    }

    public function currentStep()
    {
        return $this->steps()->where('is_completed', false)->first();
    }

    public function getProgressPercentAttribute(): int
    {
        $total = $this->steps()->count();
        $completed = $this->steps()->where('is_completed', true)->count();

        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    public function order()
{
    return $this->hasOne(\App\Models\Order::class);
}

public function tourPackage()
{
    return $this->belongsTo(TourPackage::class);
}

public function options()
{
    return $this->belongsToMany(TourOption::class, 'reservation_options');
}

public function preferences()
{
    return $this->belongsToMany(TourPreference::class, 'reservation_preferences')->withPivot('custom_note');
}

}
