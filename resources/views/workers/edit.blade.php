<x-app-layout>
    <x-slot name="header">
        Работещи в {{ $firm->name }}
    </x-slot>

    <x-firms.tabs :firm-id="$firm->id">
        <x-workes.tabs
                :firm-id="$firm->id"
                :worker-id="$worker->id"
                :tab="$tab"
        />
        @livewire('workers.' . $tab, [
            'firmId' => $firm->id,
            'workerId' => $worker->id
        ])
    </x-firms.tabs>
</x-app-layout>
