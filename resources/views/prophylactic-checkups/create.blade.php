<x-app-layout>
    <x-slot name="header">
        Нов профилактичен преглед на {{ $worker->full_name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <x-prophylactic-checkups.tabs
                :firm-id="$firm->id"
                :worker-id="$worker->id"
        />
        <livewire:prophylactic-checkups.checkup1
                :firm-id="$firm->id"
                :worker-id="$worker->id"
        />
    </x-firms.tabs>
</x-app-layout>
