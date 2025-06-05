<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReservationType;
use App\Models\ReservationStepTemplate;
use Illuminate\Http\Request;

class ReservationStepTemplateController extends Controller
{
    public function index(ReservationType $type)
    {
        $steps = $type->stepTemplates()->orderBy('order')->get();
        return view('admin.reservation_step_templates.index', compact('type', 'steps'));
    }

    public function create(ReservationType $type)
    {
        return view('admin.reservation_step_templates.create', compact('type'));
    }

    public function store(Request $request, ReservationType $type)
    {
        $data = $request->validate([
            'step_key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $type->stepTemplates()->create($data);

        return redirect()->route('admin.reservation-step-templates.index', $type->id)->with('success', 'Шаг добавлен');
    }

    public function edit(ReservationType $type, ReservationStepTemplate $stepTemplate)
    {
        return view('admin.reservation_step_templates.edit', compact('type', 'stepTemplate'));
    }

    public function update(Request $request, ReservationType $type, ReservationStepTemplate $stepTemplate)
    {
        $data = $request->validate([
            'step_key' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $stepTemplate->update($data);

        return redirect()->route('admin.reservation-step-templates.index', $type->id)->with('success', 'Шаг обновлён');
    }

    public function destroy(ReservationType $type, ReservationStepTemplate $stepTemplate)
    {
        $stepTemplate->delete();
        return redirect()->route('admin.reservation-step-templates.index', $type->id)->with('success', 'Шаг удалён');
    }
}
