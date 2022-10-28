<x-app-layout>
    <x-slot name="header">
        {{ $firm->name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <livewire:firms.form :firm="$firm"/>
    </x-firms.tabs>
</x-app-layout>
