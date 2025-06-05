<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FormFieldController extends Controller
{
    public function store(Request $request, Form $form)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'type' => [
                'required',
                'string',
                Rule::in(['text', 'multiple_choice', 'checkbox', 'number', 'radio', 'file_upload', 'rating', 'scale'])
            ],
            'options' => 'nullable|array',
            'options.*' => 'nullable|string|max:255',
            'required' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['options'] = $data['options'] ?? [];
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['required'] = $request->input('required', false);

        $form->fields()->create($data);

        return back()->with('success', 'Поле добавлено');
    }

    public function update(Request $request, Form $form, FormField $field)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'type' => [
                'required',
                'string',
                Rule::in(['text', 'multiple_choice', 'checkbox', 'number', 'radio', 'file_upload', 'rating', 'scale'])
            ],
            'options' => 'nullable|array',
            'options.*' => 'nullable|string|max:255',
            'required' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['options'] = $data['options'] ?? [];
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['required'] = $request->input('required', false);

        $field->update($data);

        return back()->with('success', 'Поле обновлено');
    }

    public function destroy(Form $form, FormField $field)
    {
        $field->delete();
        return back()->with('success', 'Поле удалено');
    }
}
