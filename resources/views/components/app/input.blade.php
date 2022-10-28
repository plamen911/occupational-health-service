@props(['disabled' => false])

@php
    $name = ($attributes->wire('model')->value() ? $attributes->wire('model')->value() : null) ?? $attributes['name'] ?? \Illuminate\Support\Str::random(10);
    $hasError = $name && $errors->has($name);
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['autocomplete' => 'off', 'class' => 'block mt-1 w-full rounded-md form-input focus:border-indigo-600']) !!}>
@if($hasError)
    @error($name)
        <x-app.error-message>
            {{ $message }}
        </x-app.error-message>
    @enderror
@endif
