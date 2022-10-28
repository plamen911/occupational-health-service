@php
    $name = ($attributes->wire('model')->value() ? $attributes->wire('model')->value() : null) ?? $attributes['name'] ?? \Illuminate\Support\Str::random(10);
    $hasError = $name && $errors->has($name);

    $defaultWidth = 'w-full';
    if (preg_match('/(w-[a-z]+)/m', $attributes['class'], $m)) {
        $defaultWidth = $m[1];
    }
@endphp

<select {!! $attributes->merge(['class' => 'block mt-1 ' . $defaultWidth . ' rounded-md form-input focus:border-indigo-600']) !!}
>
    {{ $slot }}
</select>
@if($hasError)
    @error($name)
        <x-app.error-message>
            {{ $message }}
        </x-app.error-message>
    @enderror
@endif
