<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReservationType;
use Illuminate\Http\Request;

class ReservationTypeController extends Controller
{
    public function index()
    {
        $types = ReservationType::all();
        return view('admin.reservation_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.reservation_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:reservation_types',
            'description' => 'nullable|string',
            'for_tour' => 'boolean',
            'for_service' => 'boolean',
        ]);

        ReservationType::create($data);
        return redirect()->route('admin.reservation-types.index')->with('success', 'Тип резервации добавлен');
    }

    public function edit(ReservationType $reservationType)
    {
        return view('admin.reservation_types.edit', compact('reservationType'));
    }

    public function update(Request $request, ReservationType $reservationType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:reservation_types,slug,' . $reservationType->id,
            'description' => 'nullable|string',
            'for_tour' => 'boolean',
            'for_service' => 'boolean',
        ]);

        $reservationType->update($data);
        return redirect()->route('admin.reservation-types.index')->with('success', 'Тип обновлен');
    }

    public function destroy(ReservationType $reservationType)
    {
        $reservationType->delete();
        return redirect()->route('admin.reservation-types.index')->with('success', 'Тип удален');
    }
}
