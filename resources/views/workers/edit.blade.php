<x-app-layout>
    <x-slot name="header">
        @if('form' === $tab)
            Работещи в {{ $firm->name }}
        @else
            {{ $worker->full_name }}, ЕГН {{ $worker->id_number }}
        @endif

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
