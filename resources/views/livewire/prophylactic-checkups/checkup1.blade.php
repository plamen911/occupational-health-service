<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-3 gap-4">
                    <div class="mr-3">
                        <x-input-label for="card-select">{{ __('Choose...') }}</x-input-label>
                        <div class="flex space-x-3">
                            <div class="w-full">
                                <x-app.select
                                        id="card-select"
                                        wire:model="prophylacticCheckupId"
                                        wire:loading.attr="disabled"
                                >
                                    <option value="">- НОВА КАРТА - </option>
                                    @foreach($prophylacticCheckupDropdown as $key => $val)
                                        <option value="{{ $key }}">Карта от {{ $val->format('d.m.Y') }} г.</option>
                                    @endforeach
                                </x-app.select>
                            </div>
                            @if (!empty($prophylacticCheckupId))
                                <button type="button"
                                        wire:click="confirmDelete({{ $prophylacticCheckupId }})"
                                        wire:loading.attr="disabled"
                                        class="text-red-600">
                                    <x-app.icon-delete/>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div>
                        <x-input-label for="checkup_num">Преглед №</x-input-label>
                        <x-app.input
                                type="text"
                                id="checkup_num"
                                wire:model.defer="item.checkup_num"
                                wire:loading.attr="disabled"
                                placeholder="Преглед №"
                        />
                    </div>
                    <div>
                        <x-input-label for="checkup_date">Дата</x-input-label>
                        <x-app.date-picker wire:model.defer="item.checkup_date" />
                        @error('item.checkup_date')
                            <x-app.error-message>{{ $message }}</x-app.error-message>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-4 mt-4">
                    <div>
                        <x-input-label for="worker_height">Ръст, см</x-input-label>
                        <x-app.input
                                type="number"
                                step="any"
                                id="worker_height"
                                wire:model.defer="item.worker_height"
                                wire:loading.attr="disabled"
                                placeholder="Ръст"
                        />
                    </div>
                    <div>
                        <x-input-label for="worker_weight">Тегло, кг</x-input-label>
                        <x-app.input
                                type="number"
                                step="any"
                                id="worker_weight"
                                wire:model.defer="item.worker_weight"
                                wire:loading.attr="disabled"
                                placeholder="Тегло"
                        />
                    </div>
                    <div>
                        <x-input-label for="rr_systolic">RR сист.</x-input-label>
                        <x-app.input
                                type="number"
                                id="rr_systolic"
                                wire:model.defer="item.rr_systolic"
                                wire:loading.attr="disabled"
                                placeholder="RR сист."
                        />
                    </div>
                    <div>
                        <x-input-label for="rr_diastolic">RR диаст.</x-input-label>
                        <x-app.input
                                type="number"
                                id="rr_diastolic"
                                wire:model.defer="item.rr_diastolic"
                                wire:loading.attr="disabled"
                                placeholder="RR диаст."
                        />
                    </div>
                    <div>
                        <x-input-label for="sport_hours">Физ. активност, часа</x-input-label>
                        <x-app.input
                                type="number"
                                step="any"
                                id="sport_hours"
                                wire:model.defer="item.sport_hours"
                                wire:loading.attr="disabled"
                                placeholder="RR диаст."
                        />
                    </div>
                </div>

                <div class="mt-6 flex justify-start space-x-5 flex-wrap">
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="is_smoking"
                                   wire:model.defer="item.is_smoking"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="is_smoking">Тютюнопушене</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="is_drinking"
                                   wire:model.defer="item.is_drinking"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="is_drinking">Алкохол</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="has_bad_nutrition"
                                   wire:model.defer="item.has_bad_nutrition"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="has_bad_nutrition">Нерационално хранене</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="in_on_diet"
                                   wire:model.defer="item.in_on_diet"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="in_on_diet">Диета</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="has_home_stress"
                                   wire:model.defer="item.has_home_stress"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="has_home_stress">Стрес в дома</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="has_work_stress"
                                   wire:model.defer="item.has_work_stress"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="has_work_stress">Стрес в работата</x-input-label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-start space-x-5 flex-wrap">
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="has_social_stress"
                                   wire:model.defer="item.has_social_stress"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="has_social_stress">Социален стрес</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="has_long_screen_time"
                                   wire:model.defer="item.has_long_screen_time"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="has_long_screen_time">ВИДЕОДИСПЛЕЙ повече от 1/2 от раб. време</x-input-label>
                        </div>
                    </div>
                    <div class="flex items-start whitespace-nowrap">
                        <div class="flex h-5 items-center">
                            <input type="checkbox"
                                   id="has_low_activity"
                                   wire:model="item.has_low_activity"
                                   wire:loading.attr="disabled"
                                   value="1"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3">
                            <x-input-label for="has_low_activity">Намалена двигателна активност</x-input-label>
                        </div>
                    </div>
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
