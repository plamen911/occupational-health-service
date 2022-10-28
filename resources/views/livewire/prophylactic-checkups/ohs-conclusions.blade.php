<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div>
                    <x-input-label for="conclusion-select">Заключение на СТМ:</x-input-label>
                    <div class="flex space-x-3">
                        <div class="mt-3 whitespace-nowrap">
                            Лицето
                        </div>
                        <x-app.select
                                id="conclusion-select"
                                wire:model="item.ohs_conclusion_id"
                                wire:loading.attr="disabled"
                                class="w-fit"
                                required
                        >
                            <option value="">{{ __('Choose...') }}</option>
                            @foreach($ohsConclusionDropdown as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </x-app.select>
                        <div class="mt-3 whitespace-nowrap">
                            да изпълнява тази длъжност/професия
                        </div>
                    </div>
                </div>
                <div class="mt-4 @if(!$showConditions) hidden @endif ">
                    <x-input-label for="ohs_conditions">Условия</x-input-label>
                    <x-app.textarea
                            id="ohs_conditions"
                            wire:model.defer="item.ohs_conditions"
                            wire:loading.attr="disabled"
                            placeholder="Условия"
                    />
                </div>
                <div class="mt-4">
                    <x-input-label for="ohs_date">Дата на изготвяне</x-input-label>
                    <x-app.date-picker wire:model.defer="item.ohs_date" class="w-48" />
                    @error('item.ohs_date')
                        <x-app.error-message>{{ $message }}</x-app.error-message>
                    @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <x-primary-button wire:loading.remove wire:target="save">
                        {{ __('Save') }}
                    </x-primary-button>
                    <x-app.loading-indicator wire:loading wire:target="save" class="mt-2"/>
                </div>
            </form>
        </div>
    </div>
</div>
