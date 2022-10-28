<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div>
                    <button type="button"
                            wire:click="addMedicalOpinion"
                            wire:loading.attr="disabled"
                            class="text-green-600">
                        <div class="flex space-x-2">
                            <x-app.icon-add/>
                            <div>Добави заключение</div>
                        </div>
                    </button>
                </div>

                <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                    <x-app.table>
                        <x-slot:header>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Специалист</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Име и заключение</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">&nbsp;</div>
                            </x-app.table-th>
                        </x-slot:header>
                        @foreach($item['medical_opinions'] as $i => $medicalOpinion)
                            <tr wire:key="{{ $i }}">
                                <x-app.table-column>
                                    @if(empty($medicalOpinion['name']))
                                        <x-app.select
                                                wire:model.lazy="item.medical_opinions.{{ $i }}.id"
                                                wire:loading.attr="disabled"
                                                required
                                        >
                                            <option value="">{{ __('Choose...') }}</option>
                                            @foreach($medicalSpecialistDropdown as $key => $val)
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </x-app.select>
                                    @else
                                        <div class="mt-2 whitespace-nowrap">{{ $medicalOpinion['name'] }}</div>
                                    @endif
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.textarea
                                            wire:model.defer="item.medical_opinions.{{ $i }}.medical_opinion"
                                            wire:loading.attr="disabled"
                                            placeholder="Име и заключение"
                                    />
                                </x-app.table-column>
                                <x-app.table-column class="text-right">
                                    <div class="mt-2 whitespace-nowrap">
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
