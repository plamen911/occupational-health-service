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
                                <div class="mt-2 whitespace-nowrap">Дата</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">МКБ</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Диагноза</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Комисия</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Срок</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">Място на трудоустрояване</div>
                            </x-app.table-th>
                            <x-app.table-th>
                                <div class="mt-2 whitespace-nowrap">&nbsp;</div>
                            </x-app.table-th>
                        </x-slot:header>
                        @foreach($item['employabilities'] as $i => $employability)
                            <tr wire:key="{{ $i }}">
                                <x-app.table-column>
                                    <x-app.date-picker wire:model.defer="item.employabilities.{{ $i }}.published_at" class="w-48" required />
                                    @error('item.employabilities.' . $i . '.published_at')
                                        <x-app.error-message>{{ $message }}</x-app.error-message>
                                    @enderror
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.input
                                            type="text"
                                            id="mkb-code-{{ $i }}"
                                            wire:model.defer="item.employabilities.{{ $i }}.mkb_code"
                                            wire:loading.attr="disabled"
                                            wire:ignore
                                            required
                                            placeholder="МКБ"
                                            class="w-32"
                                    />
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.textarea
                                            wire:model.defer="item.employabilities.{{ $i }}.diagnosis"
                                            wire:loading.attr="disabled"
                                            placeholder="Диагноза"
                                            class="h-20"
                                    />
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.select
                                            wire:model.defer="item.employabilities.{{ $i }}.authorities"
                                            wire:loading.attr="disabled"
                                    >
                                        <option value="">{{ __('Choose...') }}</option>
                                        @foreach(\App\Models\Employability::authorityDropdown() as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </x-app.select>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <div class="whitespace-nowrap flex justify-end space-x-3">
                                        <x-input-label for="start-date-{{ $i }}" class="mt-4">от</x-input-label>
                                        <x-app.date-picker
                                                id="start-date-{{ $i }}"
                                                wire:model.defer="item.employabilities.{{ $i }}.start_date"
                                                class="w-48"
                                        />
                                        @error('item.employabilities.' . $i . '.start_date')
                                            <x-app.error-message>{{ $message }}</x-app.error-message>
                                        @enderror
                                    </div>
                                    <div class="whitespace-nowrap flex justify-end space-x-3">
                                        <x-input-label for="end-date-{{ $i }}" class="mt-4">до</x-input-label>
                                        <x-app.date-picker
                                                id="end-date-{{ $i }}"
                                                wire:model.defer="item.employabilities.{{ $i }}.end_date"
                                                class="w-48"
                                        />
                                        @error('item.employabilities.' . $i . '.end_date')
                                            <x-app.error-message>{{ $message }}</x-app.error-message>
                                        @enderror
                                    </div>
                                </x-app.table-column>
                                <x-app.table-column>
                                    <x-app.textarea
                                            wire:model.defer="item.employabilities.{{ $i }}.employability_place"
                                            wire:loading.attr="disabled"
                                            placeholder="Място на трудоустрояване"
                                            class="h-20"
                                    />
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

    <script>
      function attachAutocomplete() {
        $('input[id^="mkb-code-"]').autocomplete({
          source: '{{ route('autocomplete', 'mkb-code') }}',
          select: function (event, ui) {
            const idx = this.id.split('-')[2]

            @this.set('item.employabilities.' + idx + '.mkb_code', ui.item.value)
            @this.set('item.employabilities.' + idx + '.diagnosis', ui.item.desc)
          }
        })
      }

      document.addEventListener('livewire:load', function () {
        $(function () {
          attachAutocomplete()
        })
      })

      window.addEventListener('attach-autocomplete', () => {
        attachAutocomplete()
      })
    </script>
</div>
