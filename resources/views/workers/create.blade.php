<x-app-layout>
    <x-slot name="header">
        Работещи в {{ $firm->name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <x-workes.tabs :firm-id="$firm->id"/>
        <livewire:workers.form :firm-id="$firm->id"/>
    </x-firms.tabs>
</x-app-layout>
