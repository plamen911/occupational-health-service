<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-2 gap-4">
                <form wire:submit.prevent="save">

                    <div class="whitespace-nowrap">
                        <button type="button"
                                wire:click="addPatientChart({{ $workerId }})"
                                wire:loading.remove
                                wire:target="addPatientChart({{ $workerId }})"
                                class="text-green-600"
                        >
                            <div class="flex space-x-2">
                                <x-app.icon-add/>
                                <div>Добави болничен</div>
                            </div>
                        </button>
                        <x-app.loading-indicator
                                wire:loading
                                wire:target="addPatientChart({{ $workerId }})"
                        />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
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
                            <x-input-label for="checkup_num">Болничен лист №</x-input-label>
                            <x-app.input
                                    type="text"
                                    id="reg_num"
                                    wire:model.defer="item.reg_num"
                                    wire:loading.attr="disabled"
                                    placeholder="Болничен лист №"
                                    required
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="worker_name">Име</x-input-label>
                        <x-app.input
                                type="text"
                                id="worker_name"
                                wire:model.defer="item.worker_name"
                                wire:loading.attr="disabled"
                                placeholder="Име"
                                required
                        />
                    </div>
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div>
                            <x-input-label for="start_date">От дата</x-input-label>
                            <x-app.date-picker wire:model="item.start_date" />
                            @error('item.start_date')
                                <x-app.error-message>{{ $message }}</x-app.error-message>
                            @enderror
                        </div>
                        <div>
                            <x-input-label for="end_date">До дата</x-input-label>
                            <x-app.date-picker wire:model="item.end_date" />
                            @error('item.end_date')
                                <x-app.error-message>{{ $message }}</x-app.error-message>
                            @enderror
                        </div>
                        <div>
                            <x-input-label for="days_off">ВН /дни/</x-input-label>
                            <x-app.input
                                    type="number"
                                    id="days_off"
                                    wire:model.lazy="item.days_off"
                                    wire:loading.attr="disabled"
                                    placeholder="ВН /дни/"
                                    readonly
                            />
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-start space-x-3">
                            <x-input-label for="mkb-code" class="mt-4">МКБ</x-input-label>
                            <x-app.input
                                    type="text"
                                    id="mkb-code"
                                    wire:model.defer="item.mkb_code"
                                    wire:loading.attr="disabled"
                                    wire:ignore
                                    required
                                    placeholder="МКБ"
                                    class="w-32"
                            />
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="text-gray-700 text-sm">
                                                {{ $item['mkb_desc'] ?? '' }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="patient_chart_reason_id">Причина</x-input-label>
                        <x-app.select
                                id="patient_chart_reason_id"
                                wire:model.defer="item.patient_chart_reason_id"
                                wire:loading.attr="disabled"
                        >
                            <option value="">{{ __('Choose...') }}</option>
                            @foreach($patientChartReasonDropdown as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </x-app.select>
                    </div>

                    <div class="mt-4">

                        <div class="flex justify-start space-x-5 flex-wrap">
                            @foreach(\App\Models\PatientChartType::dropdown() as $key => $val)
                                <div class="flex items-start whitespace-nowrap" wire:key="{{ $loop->index }}">
                                    <div class="flex h-5 items-center">
                                        <input type="checkbox"
                                               id="patient-chart-type-{{ $key }}"
                                               wire:model.defer="item.patient_chart_types.{{ $loop->index }}"
                                               wire:loading.attr="disabled"
                                               value="{{ $key }}"
                                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        />
                                    </div>
                                    <div class="ml-3">
                                        <x-input-label for="patient-chart-type-{{ $key }}">{{ $val }}</x-input-label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="notes">Разширена диагноза</x-input-label>
                        <x-app.textarea
                                id="notes"
                                wire:model.defer="item.notes"
                                wire:loading.attr="disabled"
                                placeholder="Разширена диагноза"
                        />
                    </div>

                    <div class="flex justify-between mt-6">
                        <div class="whitespace-nowrap mt-1">
                            @if(!empty($item['id']))
                                <button type="button"
                                        wire:click="confirmDelete({{ $item['id'] }})"
                                        wire:loading.attr="disabled"
                                        class="text-red-600"
                                >
                                    <div class="flex space-x-2">
                                        <x-app.icon-delete/>
                                        <div>{{ __('Delete') }}</div>
                                    </div>
                                </button>
                            @endif
                        </div>

                        <div>
                            <x-primary-button wire:loading.remove wire:target="save">
                                {{ __('Save') }}
                            </x-primary-button>
                            <x-app.loading-indicator wire:loading wire:target="save" class="mt-2"/>
                        </div>
                    </div>
                </form>

                <div>
                    @if(count($item['patient_charts']) > 0)
                        <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                            <x-app.table>
                                <x-slot:header>
                                    <x-app.table-th>От</x-app.table-th>
                                    <x-app.table-th>На работа</x-app.table-th>
                                    <x-app.table-th>МКБ</x-app.table-th>
                                    <x-app.table-th>Вид</x-app.table-th>
                                    <x-app.table-th>Причина</x-app.table-th>
                                    <x-app.table-th>&nbsp;</x-app.table-th>
                                </x-slot:header>
                                @foreach($item['patient_charts'] as $patientChart)
                                    <tr>
                                        <x-app.table-column>
                                            <div class="mt-2 whitespace-nowrap">
                                                <x-app.link
                                                        href="#" wire:click.prevent="editPatientChart({{ $patientChart['id'] }})"
                                                        wire:loading.remove
                                                        wire:target="editPatientChart({{ $patientChart['id'] }})"
                                                >
                                                    {{ $patientChart['start_date'] }}
                                                </x-app.link>
                                                <x-app.loading-indicator
                                                        wire:loading
                                                        wire:target="editPatientChart({{ $patientChart['id'] }})"
                                                />
                                            </div>
                                        </x-app.table-column>
                                        <x-app.table-column>
                                            <div class="mt-2 whitespace-nowrap">{{ $patientChart['end_date'] }}</div>
                                        </x-app.table-column>
                                        <x-app.table-column>
                                            <div class="mt-2 whitespace-nowrap">{{ $patientChart['mkb_code'] }}</div>
                                        </x-app.table-column>
                                        <x-app.table-column>
                                            <div class="mt-2 whitespace-nowrap">{{ collect($patientChart['patient_chart_types'])->join(', ') }}</div>
                                        </x-app.table-column>
                                        <x-app.table-column>
                                            <div class="mt-2 whitespace-nowrap">{{ $patientChart['patient_chart_reason'] }}</div>
                                        </x-app.table-column>
                                        <x-app.table-column>
                                            <div class="mt-2 whitespace-nowrap">
                                                <button type="button"
                                                        wire:click="confirmDelete({{ $patientChart['id'] }})"
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
      document.addEventListener('livewire:load', function () {
        $(function () {
          $('#mkb-code').autocomplete({
            source: '{{ route('autocomplete', 'mkb-code') }}',
            select: function (event, ui) {
              @this.set('item.mkb_code', ui.item.value)
              @this.set('item.mkb_desc', ui.item.desc)
            }
          })
        })
      })
    </script>
</div>
