<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div>
                    <button type="button"
                            wire:click="addLaboratoryResearch"
                            wire:loading.attr="disabled"
                            class="text-green-600">
                        <div class="flex space-x-2">
                            <x-app.icon-add/>
                            <div>Добави изследване</div>
                        </div>
                    </button>
                </div>

                <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                    <x-app.table>
                        <x-slot:header>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Вид</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Показател</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Ниво</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">МЕ</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Min</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Max</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Откл.</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">&nbsp;</div>
                            </x-app.table-th>
                        </x-slot:header>
                        @foreach($item['laboratory_researches'] as $i => $laboratoryResearch)
                            <tr wire:key="{{ $i }}">
                                <x-app.table-column>
                                    <x-app.input
                                            type="text"
                                            wire:model.defer="item.laboratory_researches.{{ $i }}.type"
                                            wire:loading.attr="disabled"
                                            placeholder="Вид"
                                    />
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.select
                                            wire:model.lazy="item.laboratory_researches.{{ $i }}.laboratory_indicator_id"
                                            wire:loading.attr="disabled"
                                            required
                                    >
                                        <option value="">{{ __('Choose...') }}</option>
                                        @foreach($laboratoryIndicatorDropdown as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </x-app.select>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.input
                                            type="text"
                                            wire:model.defer="item.laboratory_researches.{{ $i }}.value"
                                            wire:loading.attr="disabled"
                                            placeholder="Ниво"
                                    />
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="mt-2 whitespace-nowrap">{{ $laboratoryResearch['dimension'] }}</div>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="mt-2 whitespace-nowrap">{{ $laboratoryResearch['min_value'] }}</div>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="mt-2 whitespace-nowrap">{{ $laboratoryResearch['max_value'] }}</div>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="mt-2 whitespace-nowrap">
                                        @if('up' === $laboratoryResearch['deviation'])
                                            <x-app.icon-plus class="text-red-600" />
                                        @elseif('down' === $laboratoryResearch['deviation'])
                                            <x-app.icon-minus class="text-red-600" />
                                        @endif
                                    </div>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="mt-2 whitespace-nowrap text-right">
                                        <button type="button"
                                                wire:click="confirmDelete({{ $i }})"
                                                wire:loading.attr="disabled"
                                                class="text-red-600">
                                            <x-app.icon-delete/>
                                        </button>
                                    </div>
                                </x-app.table-column>
                            </tr>
                        @endforeach
                    </x-app.table>
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
