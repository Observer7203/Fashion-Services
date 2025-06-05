<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ReservationStep;

class ReservationController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->latest()->get();
        return view('cabinet.reservations.index', compact('reservations'));
    }

    public function create()
{
    $types = \App\Models\ReservationType::all();
    return view('cabinet.reservations.create', compact('types'));
}

public function store(Request $request)
{
    $data = $request->validate([
        'type_id' => 'required|exists:reservation_types,id',
        'tour_id' => 'nullable|exists:tours,id',
        'service_id' => 'nullable|exists:services,id',
        'tour_package_id' => 'required|exists:tour_packages,id',
        'options' => 'nullable|array',
        'options.*' => 'exists:tour_options,id',
        'preferences' => 'nullable|array',
        'preferences.*.id' => 'exists:tour_preferences,id',
        'preferences.*.note' => 'nullable|string',
    ]);

    $type = ReservationType::findOrFail($data['type_id']);

    // Проверка соответствия типа тура/услуги
    if (!empty($data['tour_id'])) {
        $tour = \App\Models\Tour::findOrFail($data['tour_id']);
        if ($tour->reservation_type_id != $type->id) {
            return back()->withErrors(['type_id' => 'Выбранный тип не соответствует туру']);
        }
    }

    if (!empty($data['service_id'])) {
        $service = \App\Models\Service::findOrFail($data['service_id']);
        if ($service->reservation_type_id != $type->id) {
            return back()->withErrors(['type_id' => 'Выбранный тип не соответствует услуге']);
        }
    }

    // Создание резервации
    $reservation = Reservation::create([
        'user_id' => auth()->id(),
        'reservation_type_id' => $type->id,
        'tour_id' => $data['tour_id'] ?? null,
        'service_id' => $data['service_id'] ?? null,
        'tour_package_id' => $data['tour_package_id'],
        'status' => 'pending',
    ]);

    // Шаги резервации
    foreach ($type->steps()->orderBy('order')->get() as $template) {
        $reservation->steps()->create([
            'step_key' => $template->step_key,
            'title' => $template->title,
            'description' => $template->description,
            'order' => $template->order,
        ]);
    }

    // Опции
    if (!empty($data['options'])) {
        $reservation->options()->sync($data['options']);
    }

    // Предпочтения + notes
    if (!empty($data['preferences'])) {
        $pivotData = [];
        foreach ($data['preferences'] as $pref) {
            $pivotData[$pref['id']] = ['custom_note' => $pref['note'] ?? null];
        }
        $reservation->preferences()->sync($pivotData);
    }

    return redirect()->route('reservations.show', $reservation)->with('success', 'Бронирование создано');
}


    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        $steps = $reservation->steps()->orderBy('order')->get();
        $currentStep = $reservation->currentStep();
        $progress = $reservation->progress_percent;

        return view('cabinet.reservations.show', compact('reservation', 'steps', 'currentStep', 'progress'));
    }

    public function completeStep(Reservation $reservation, ReservationStep $step)
{
    $this->authorize('update', $reservation);

    if ($step->reservation_id !== $reservation->id) {
        abort(403);
    }

    $step->update([
        'is_completed' => true,
        'completed_at' => now(),
    ]);

    return back()->with('success', 'Этап завершён');
}

public function cancel(Reservation $reservation)
{
    $this->authorize('update', $reservation);

    if ($reservation->status === 'completed') {
        return back()->withErrors(['error' => 'Завершённые бронирования нельзя отменить.']);
    }

    $reservation->update([
        'status' => 'cancelled',
    ]);

    return redirect()->route('reservations.index')->with('success', 'Бронирование отменено');
}

}

