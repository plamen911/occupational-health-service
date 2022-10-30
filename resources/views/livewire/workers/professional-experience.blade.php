<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div>
                    <button type="button"
                            wire:click="addRecord"
                            wire:loading.attr="disabled"
                            class="text-green-600">
                        <div class="flex space-x-2">
                            <x-app.icon-add/>
                            <div>Добави запис</div>
                        </div>
                    </button>
                </div>

                <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                    <x-app.table>
                        <x-slot:header>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Предприятие</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Длъжност/професия</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Продължителност на стажа</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">&nbsp;</div>
                            </x-app.table-th>
                        </x-slot:header>
                        @foreach($item['professional_experiences'] as $i => $professionalExperience)
                            <tr wire:key="{{ $i }}">
                                <x-app.table-column>
                                    <x-app.input
                                            type="text"
                                            wire:model.defer="item.professional_experiences.{{ $i }}.firm_name"
                                            wire:loading.attr="disabled"
                                            placeholder="Предприятие"
                                            required
                                    />
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.input
                                            type="text"
                                            wire:model.defer="item.professional_experiences.{{ $i }}.job_position"
                                            wire:loading.attr="disabled"
                                            placeholder="Длъжност/професия"
                                            required
                                    />
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="whitespace-nowrap">
                                        <div class="flex justify-start space-x-3">
                                            <x-app.input
                                                    type="number"
                                                    wire:model.defer="item.professional_experiences.{{ $i }}.years_length"
                                                    wire:loading.attr="disabled"
                                                    step="any"
                                                    class="w-24"
                                            />
                                            <div class="mt-4">г.</div>
                                            <x-app.input
                                                    type="number"
                                                    wire:model.defer="item.professional_experiences.{{ $i }}.months_length"
                                                    wire:loading.attr="disabled"
                                                    step="any"
                                                    class="w-24"
                                            />
                                            <div class="mt-4">м.</div>
                                        </div>
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

                <div class="flex justify-end mt-4">
                    <x-primary-button wire:loading.remove wire:target="save">
                        {{ __('Save') }}
                    </x-primary-button>
                    <x-app.loading-indicator wire:loading wire:target="save" class="mt-2"/>
                </div>
            </form>
        </div>
    </div>
</div>
