<x-app-layout>
    <x-slot name="header">
        Работещи в {{ $firm->name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <livewire:workers.index :firm="$firm"/>
    </x-firms.tabs>
</x-app-layout>
