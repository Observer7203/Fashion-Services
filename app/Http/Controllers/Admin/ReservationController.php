<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationStep;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Reservation::with('user', 'tour', 'service')->latest();
    
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
    
        $reservations = $query->paginate(20);
    
        return view('admin.reservations.index', compact('reservations'));
    }    

    public function edit(Reservation $reservation)
    {
        $steps = $reservation->steps()->orderBy('order')->get();
        return view('admin.reservations.edit', compact('reservation', 'steps'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'admin_notes' => 'nullable|string',
        ]);

        $reservation->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // Обновление шагов
        if ($request->has('steps')) {
            foreach ($request->steps as $stepId => $data) {
                $step = ReservationStep::find($stepId);
                if ($step && $step->reservation_id === $reservation->id) {
                    $step->update([
                        'is_completed' => isset($data['is_completed']),
                        'completed_at' => isset($data['is_completed']) ? now() : null,
                    ]);
                }
            }
        }

        return redirect()->route('reservations.index')->with('success', 'Бронирование обновлено');
    }
}
