<x-app-layout>
    <x-slot name="header">
        Профилактичен преглед на {{ $worker->full_name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <x-prophylactic-checkups.tabs
                :firm-id="$firm->id"
                :worker-id="$worker->id"
                :prophylactic-checkup-id="$prophylacticCheckup->id"
                :tab="$tab"
        />
        @livewire('prophylactic-checkups.' . $tab, [
            'firmId' => $firm->id,
            'workerId' => $worker->id,
            'prophylacticCheckupId' => $prophylacticCheckup->id
        ])
    </x-firms.tabs>
</x-app-layout>
