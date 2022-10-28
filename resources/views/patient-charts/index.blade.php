<x-app-layout>
    <x-slot name="header">
        Болнични листове на {{ $worker->full_name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <x-patient-charts.tabs
                :firm-id="$firm->id"
                :worker-id="$worker->id"
        />
        <livewire:patient-charts.form :firm-id="$firm->id" :worker-id="$worker->id"/>
    </x-firms.tabs>
</x-app-layout>
