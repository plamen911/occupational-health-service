<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div>
                    <button type="button"
                            wire:click="addDiagnosis"
                            wire:loading.attr="disabled"
                            class="text-green-600">
                        <div class="flex space-x-2">
                            <x-app.icon-add/>
                            <div>Добави диагноза</div>
                        </div>
                    </button>
                </div>

                <ul class="grid grid-cols-2 gap-4">
                    @foreach($item['diagnoses'] as $i => $diagnosis)
                        <li wire:key="{{ $i }}" class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                            <div class="flex justify-between space-x-3 items-center">
                                <div class="flex justify-start space-x-3 items-center">
                                    <x-input-label for="mkb-code-{{ $i }}" class="mt-1">МКБ</x-input-label>
                                    <x-app.input
                                            type="text"
                                            id="mkb-code-{{ $i }}"
                                            wire:model.defer="item.diagnoses.{{ $i }}.mkb_code"
                                            wire:loading.attr="disabled"
                                            wire:ignore
                                            required
                                            placeholder="МКБ"
                                            class="w-32"
                                    />
                                    <div class="text-gray-700 text-sm">{{ $diagnosis['mkb_desc'] }}</div>
                                </div>
                                <button type="button"
                                        wire:click="confirmDelete({{ $i }})"
                                        wire:loading.attr="disabled"
                                        class="text-red-600">
                                    <x-app.icon-delete/>
                                </button>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="diagnosis-{{ $i }}" class="hidden">Диагноза</x-input-label>
                                <x-app.textarea
                                        id="diagnosis-{{ $i }}"
                                        wire:model.defer="item.diagnoses.{{ $i }}.diagnosis"
                                        wire:loading.attr="disabled"
                                        placeholder="Диагноза"
                                />
                            </div>
                            <div class="mt-4">
                                <div class="flex items-start whitespace-nowrap">
                                    <div class="flex h-5 items-center">
                                        <input type="checkbox"
                                               id="is-new-{{ $i }}"
                                               wire:model.defer="item.diagnoses.{{ $i }}.is_new"
                                               wire:loading.attr="disabled"
                                               value="1"
                                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        />
                                    </div>
                                    <div class="ml-3">
                                        <x-input-label for="is-new-{{ $i }}">Новооткрито</x-input-label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="flex justify-end mt-6">
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

            @this.set('item.diagnoses.' + idx + '.mkb_code', ui.item.value)
            @this.set('item.diagnoses.' + idx + '.mkb_desc', ui.item.desc)
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
