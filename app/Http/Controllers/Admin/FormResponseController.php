<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Http\Request;

class FormResponseController extends Controller
{
    public function index(Request $request)
    {
        $formId = $request->get('form_id');
        $responses = FormResponse::with(['form', 'user', 'reservation'])
            ->when($formId, fn($q) => $q->where('form_id', $formId))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.form_responses.index', compact('responses'));
    }

    public function show(FormResponse $response)
    {
        $response->load(['form', 'user', 'reservation']);
        return view('admin.form_responses.show', compact('response'));
    }
}
