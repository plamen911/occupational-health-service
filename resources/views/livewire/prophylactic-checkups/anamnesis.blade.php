<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div>
                    <x-input-label for="medical_history">Анамнеза</x-input-label>
                    <x-app.textarea
                            id="medical_history"
                            wire:model.defer="item.medical_history"
                            wire:loading.attr="disabled"
                            placeholder="Описание"
                    />
                </div>

                <div class="mt-4">
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
                    @foreach($item['anamneses'] as $i => $anamnesis)
                        <li wire:key="{{ $i }}" class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                            <div class="flex justify-between space-x-3 items-center">
                                <div class="flex justify-start space-x-3 items-center">
                                    <x-input-label for="mkb-code-{{ $i }}" class="mt-1">МКБ</x-input-label>
                                    <x-app.input
                                            type="text"
                                            id="mkb-code-{{ $i }}"
                                            wire:model.defer="item.anamneses.{{ $i }}.mkb_code"
                                            wire:loading.attr="disabled"
                                            wire:ignore
                                            required
                                            placeholder="МКБ"
                                            class="w-32"
                                    />
                                    <div class="text-gray-700 text-sm">{{ $anamnesis['mkb_desc'] }}</div>
                                </div>
                                <button type="button"
                                        wire:click="confirmDelete({{ $i }})"
                                        wire:loading.attr="disabled"
                                        class="text-red-600">
                                    <x-app.icon-delete/>
                                </button>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="anamnesis-{{ $i }}" class="hidden">Диагноза</x-input-label>
                                <x-app.textarea
                                        id="anamnesis-{{ $i }}"
                                        wire:model.defer="item.anamneses.{{ $i }}.diagnosis"
                                        wire:loading.attr="disabled"
                                        placeholder="Диагноза"
                                />
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

            @this.set('item.anamneses.' + idx + '.mkb_code', ui.item.value)
            @this.set('item.anamneses.' + idx + '.mkb_desc', ui.item.desc)
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
