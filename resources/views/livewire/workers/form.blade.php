<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="first_name">Име</x-input-label>
                        <x-app.input
                                type="text"
                                id="first_name"
                                wire:model.defer="item.first_name"
                                wire:loading.attr="disabled"
                                placeholder="Име"
                                required
                        />
                    </div>
                    <div>
                        <x-input-label for="first_name">Презиме</x-input-label>
                        <x-app.input
                                type="text"
                                id="second_name"
                                wire:model.defer="item.second_name"
                                wire:loading.attr="disabled"
                                placeholder="Презиме"
                        />
                    </div>
                    <div>
                        <x-input-label for="last_name">Фамилия</x-input-label>
                        <x-app.input
                                type="text"
                                id="last_name"
                                wire:model.defer="item.last_name"
                                wire:loading.attr="disabled"
                                placeholder="Фамилия"
                        />
                    </div>
                    <div>
                        <x-input-label for="id_number">ЕГН/ЛНЧ</x-input-label>
                        <x-app.input
                                type="number"
                                id="id_number"
                                wire:model.lazy="item.id_number"
                                wire:loading.attr="disabled"
                                placeholder="ЕГН/ЛНЧ"
                                required
                        />
                    </div>
                    <div>
                        <x-input-label for="gender">Пол</x-input-label>
                        <x-app.select
                                id="gender"
                                wire:model.defer="item.gender"
                                wire:loading.attr="disabled"
                                required
                        >
                            <option value="">{{ __('Choose...') }}</option>
                            <option value="f">Жена</option>
                            <option value="m">Мъж</option>
                        </x-app.select>
                    </div>
                    <div>
                        <x-input-label for="birth_date">Дата на раждане</x-input-label>
                        <x-app.date-picker wire:model.defer="item.birth_date" />
                        @error('item.birth_date')
                            <x-app.error-message>{{ $message }}</x-app.error-message>
                        @enderror
                    </div>
                    <div>
                        <x-input-label for="address">Адрес</x-input-label>
                        <x-app.input
                                type="text"
                                id="address"
                                wire:model.defer="item.address"
                                wire:loading.attr="disabled"
                                placeholder="Адрес"
                        />
                    </div>
                    <div>
                        <x-input-label for="phone1">Тел. 1</x-input-label>
                        <x-app.input
                                type="tel"
                                id="phone1"
                                wire:model.defer="item.phone1"
                                wire:loading.attr="disabled"
                                placeholder="Тел. 1"
                        />
                    </div>
                    <div>
                        <x-input-label for="phone2">Тел. 2</x-input-label>
                        <x-app.input
                                type="tel"
                                id="phone2"
                                wire:model.defer="item.phone2"
                                wire:loading.attr="disabled"
                                placeholder="Тел. 2"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-4">
                    <div>
                        <x-input-label for="firm-sub-division">Подразделение</x-input-label>
                        <x-app.input
                                type="text"
                                id="firm-sub-division"
                                wire:model.defer="firmSubDivision.name"
                                wire:loading.attr="disabled"
                                wire:ignore
                                placeholder="Подразделение"
                        />
                    </div>
                    <div>
                        <x-input-label for="firm-work-place">Работно място</x-input-label>
                        <x-app.input
                                type="text"
                                id="firm-work-place"
                                wire:model.defer="firmWorkPlace.name"
                                wire:loading.attr="disabled"
                                wire:ignore
                                placeholder="Работно място"
                        />
                    </div>
                    <div>
                        <x-input-label for="firm-position">Длъжност</x-input-label>
                        <x-app.input
                                type="text"
                                id="firm-position"
                                wire:model.defer="firmPosition.name"
                                wire:loading.attr="disabled"
                                wire:ignore
                                placeholder="Длъжност"
                        />
                    </div>

                </div>

                <div class="grid grid-cols-3 gap-4 mt-4">
                    <div>
                        <x-input-label for="family-doctor">Личен лекар</x-input-label>
                        <x-app.input
                                type="text"
                                id="family-doctor"
                                wire:model.defer="familyDoctor.name"
                                wire:loading.attr="disabled"
                                wire:ignore
                                placeholder="Личен лекар"
                        />
                    </div>
                    <div>
                        <x-input-label for="notes">Бележки</x-input-label>
                        <x-app.textarea
                                id="notes"
                                wire:model.defer="item.notes"
                                wire:loading.attr="disabled"
                                placeholder="Бележки"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-4">
                    <div>
                        <x-input-label for="job_start_at">
                            Тр. стаж по настоящата длъжност от
                        </x-input-label>
                        <x-app.date-picker wire:model.debounce.500ms="item.job_start_at" />
                        <div class="text-sm mt-1 text-gray-500">{{ $jobDuration }}</div>
                        @error('item.job_start_at')
                            <x-app.error-message>{{ $message }}</x-app.error-message>
                        @enderror
                    </div>
                    <div>
                        <x-input-label for="career_start_at">Общ трудов стаж от</x-input-label>
                        <x-app.date-picker wire:model.debounce.500ms="item.career_start_at" />
                        <div class="text-sm mt-1 text-gray-500">{{ $careerDuration }}</div>
                        @error('item.career_start_at')
                            <x-app.error-message>{{ $message }}</x-app.error-message>
                        @enderror
                    </div>
                    <div>
                        <x-input-label for="retired_at" class="text-red-600 font-bold">Напуснал на</x-input-label>
                        <x-app.date-picker wire:model.debounce.500ms="item.retired_at" />
                        <div class="text-sm mt-1 text-gray-500">{{ $retirementDuration }}</div>
                        @error('item.retired_at')
                            <x-app.error-message>{{ $message }}</x-app.error-message>
                        @enderror
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

    <script>
      document.addEventListener('livewire:load', function () {
        $(function () {
          $('#family-doctor').autocomplete({
            source: '{{ route('autocomplete', 'family-doctors') }}',
            select: function (event, ui) {
              @this.set('familyDoctor.id', +ui.item.id);
              @this.set('familyDoctor.name', ui.item.value);
            }
          })

          $('#firm-sub-division').autocomplete({
            source: '{{ route('autocomplete', ['action' => 'firm-sub-divisions', 'firm_id' => $firmId]) }}',
            select: function (event, ui) {
              @this.set('firmSubDivision.id', +ui.item.id);
              @this.set('firmSubDivision.name', ui.item.value);
            }
          })

          $('#firm-work-place').autocomplete({
            source: '{{ route('autocomplete', ['action' => 'firm-work-places', 'firm_id' => $firmId]) }}',
            select: function (event, ui) {
              @this.set('firmWorkPlace.id', +ui.item.id);
              @this.set('firmWorkPlace.name', ui.item.value);
            }
          })

          $('#firm-position').autocomplete({
            source: '{{ route('autocomplete', ['action' => 'firm-positions', 'firm_id' => $firmId]) }}',
            select: function (event, ui) {
              @this.set('firmPosition.id', +ui.item.id);
              @this.set('firmPosition.name', ui.item.value);
            }
          })
        })
      })
    </script>

</div>
