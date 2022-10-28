<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="firm-name">Наименование</x-input-label>
                        <x-app.input
                                type="text"
                                id="firm-name"
                                wire:model.defer="firm.name"
                                wire:loading.attr="disabled"
                                placeholder="Наименование"
                        />
                    </div>
                    <div>
                        <x-input-label for="manager">Управител</x-input-label>
                        <x-app.input
                                type="text"
                                id="manager"
                                wire:model.defer="firm.manager"
                                wire:loading.attr="disabled"
                                placeholder="Управител"
                        />
                    </div>
                    <div>
                        <x-input-label for="address">Адрес</x-input-label>
                        <x-app.input
                                type="text"
                                id="address"
                                wire:model.defer="firm.address"
                                wire:loading.attr="disabled"
                                placeholder="Адрес"
                        />
                    </div>
                    <div>
                        <x-input-label for="email">{{ __('Email') }}</x-input-label>
                        <x-app.input
                                type="email"
                                id="email"
                                wire:model.defer="firm.email"
                                wire:loading.attr="disabled"
                                placeholder="{{ __('Email') }}"
                        />
                    </div>
                    <div>
                        <x-input-label for="phone1">Телефон</x-input-label>
                        <x-app.input
                                type="tel"
                                id="phone1"
                                wire:model.defer="firm.phone1"
                                wire:loading.attr="disabled"
                                placeholder="Телефон"
                        />
                    </div>
                    <div>
                        <x-input-label for="phone2">Телефон 2</x-input-label>
                        <x-app.input
                                type="tel"
                                id="phone2"
                                wire:model.defer="firm.phone2"
                                wire:loading.attr="disabled"
                                placeholder="Телефон 2"
                        />
                    </div>
                    <div>
                        <x-input-label for="notes">Бележки</x-input-label>
                        <x-app.textarea
                                id="notes"
                                wire:model.defer="firm.notes"
                                wire:loading.attr="disabled"
                                placeholder="Бележки"
                        />
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button wire:loading.remove wire:target="save">
                        {{ __('Save') }}
                    </x-primary-button>
                    <x-app.loading-indicator wire:loading wire:target="save" class="mt-2"/>
                </div>
            </form>
        </div>
    </div>

    <livewire:livewire-toast/>
</div>
