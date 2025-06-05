@extends('layouts.app')
@section('title', $form->name)

@section('content')
<div class="max-w-xl mx-auto my-12 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-2">{{ $form->name }}</h2>
    @if($form->description)
        <p class="mb-4 text-gray-500">{{ $form->description }}</p>
    @endif

    <form action="{{ route('reservations.steps.form.submit', [$reservation, $step]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach($form->fields->sortBy('sort_order') as $field)
            <div class="mb-4">
                <label class="block font-medium mb-1">{{ $field->label }} @if($field->required) <span class="text-red-600">*</span> @endif</label>

                @php $fieldName = "fields[{$field->id}]"; @endphp

                @switch($field->type)
                    @case('text')
                        <input type="text" name="{{ $fieldName }}" class="form-input w-full" {{ $field->required ? 'required' : '' }} value="{{ old("fields.{$field->id}") }}">
                        @break

                    @case('number')
                        <input type="number" name="{{ $fieldName }}" class="form-input w-full" {{ $field->required ? 'required' : '' }} value="{{ old("fields.{$field->id}") }}">
                        @break

                    @case('textarea')
                        <textarea name="{{ $fieldName }}" class="form-textarea w-full" rows="3" {{ $field->required ? 'required' : '' }}>{{ old("fields.{$field->id}") }}</textarea>
                        @break

                    @case('multiple_choice')
                        <select name="{{ $fieldName }}[]" class="form-select w-full" multiple {{ $field->required ? 'required' : '' }}>
                            @foreach($field->options ?? [] as $option)
                                <option value="{{ $option }}" {{ collect(old("fields.{$field->id}", []))->contains($option) ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @break

                    @case('radio')
                        @foreach($field->options ?? [] as $option)
                            <label class="mr-4">
                                <input type="radio" name="{{ $fieldName }}" value="{{ $option }}" {{ old("fields.{$field->id}") == $option ? 'checked' : '' }}> {{ $option }}
                            </label>
                        @endforeach
                        @break

                    @case('checkbox')
                        @foreach($field->options ?? [] as $option)
                            <label class="mr-4">
                                <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $option }}" {{ collect(old("fields.{$field->id}", []))->contains($option) ? 'checked' : '' }}> {{ $option }}
                            </label>
                        @endforeach
                        @break

                    @case('file_upload')
                        <input type="file" name="{{ $fieldName }}" class="form-input w-full" {{ $field->required ? 'required' : '' }}>
                        @break

                    @case('rating')
                        <input type="number" name="{{ $fieldName }}" class="form-input w-24" min="1" max="5" {{ $field->required ? 'required' : '' }} value="{{ old("fields.{$field->id}") }}">
                        <span class="text-gray-400 text-xs">1-5</span>
                        @break

                    @case('scale')
                        <input type="range" name="{{ $fieldName }}" min="1" max="10" step="1" value="{{ old("fields.{$field->id}", 5) }}">
                        <span class="ml-2">{{ old("fields.{$field->id}", 5) }}</span>
                        @break
                @endswitch

                @error("fields.{$field->id}")
                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-6">Отправить</button>
    </form>
</div>
@endsection
