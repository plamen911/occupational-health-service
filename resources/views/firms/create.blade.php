<x-app-layout>
    <x-slot name="header">
        Добавяне на фирма
    </x-slot>

    <x-firms.tabs>
        <livewire:firms.form :firm="$firm"/>
    </x-firms.tabs>
</x-app-layout>
