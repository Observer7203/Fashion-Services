<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationStep;
use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationStepFormController extends Controller
{
    // Показываем форму
    public function show(Reservation $reservation, ReservationStep $step)
    {
        $form = $step->form;
        return view('reservations.steps.form', compact('reservation', 'step', 'form'));
    }

    // Обработка отправки формы
    public function submit(Request $request, Reservation $reservation, ReservationStep $step)
    {
        $form = $step->form;
        $fields = $form->fields;
        $data = [];

        foreach ($fields as $field) {
            $name = "fields.{$field->id}";
            $value = $request->input("fields.{$field->id}");

            // Для чекбоксов всегда массив
            if (in_array($field->type, ['checkbox', 'multiple_choice']) && $value === null) {
                $value = [];
            }
            if ($field->required && (is_null($value) || $value === '' || (is_array($value) && count($value) == 0))) {
                return back()->withInput()->withErrors(["fields.{$field->id}" => 'Обязательное поле']);
            }
            $data[$field->id] = $value;
        }

        FormResponse::create([
            'form_id' => $form->id,
            'reservation_id' => $reservation->id,
            'user_id' => Auth::id(),
            'responses' => $data,
        ]);

        // Статус шага — завершён (можно реализовать статус шага)
        $step->update(['status' => 'completed']);

        return redirect()->route('reservations.show', $reservation)->with('success', 'Анкета отправлена!');
    }
}
