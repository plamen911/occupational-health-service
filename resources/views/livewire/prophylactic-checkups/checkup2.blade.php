<div>
    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-4">
                    <div>

                        <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                            <x-app.table>
                                <x-slot:header>
                                    <x-app.table-th colspan="2">Зрителна острота</x-app.table-th>
                                </x-slot:header>
                                <tr>
                                    <x-app.table-column>
                                        <div class="mt-2 whitespace-nowrap">Ляво око</div>
                                    </x-app.table-column>
                                    <x-app.table-column>
                                        <div class="flex space-x-3">
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="left_eye"
                                                    wire:model.defer="item.left_eye"
                                                    wire:loading.attr="disabled"
                                            />
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="left_eye2"
                                                    wire:model.defer="item.left_eye2"
                                                    wire:loading.attr="disabled"
                                            />
                                            <div class="mt-4">dp</div>
                                        </div>
                                    </x-app.table-column>
                                </tr>
                                <tr>
                                    <x-app.table-column>
                                        <div class="mt-2 whitespace-nowrap">Дясно око</div>
                                    </x-app.table-column>
                                    <x-app.table-column>
                                        <div class="flex space-x-3 items-center">
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="right_eye"
                                                    wire:model.defer="item.right_eye"
                                                    wire:loading.attr="disabled"
                                            />
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="right_eye2"
                                                    wire:model.defer="item.right_eye2"
                                                    wire:loading.attr="disabled"
                                            />
                                            <div class="mt-2">dp</div>
                                        </div>
                                    </x-app.table-column>
                                </tr>
                            </x-app.table>
                        </div>

                        <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                            <x-app.table>
                                <x-slot:header>
                                    <x-app.table-th>Функционално изследване на дишането</x-app.table-th>
                                </x-slot:header>
                                <tr>
                                    <x-app.table-column>
                                        <div class="flex space-x-3 items-center">
                                            <div class="mt-2">ВК</div>
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="breath_vk"
                                                    wire:model.defer="item.breath_vk"
                                                    wire:loading.attr="disabled"
                                            />
                                            <div class="mt-2 mr-3">ml</div>
                                            <div class="mt-2 whitespace-nowrap">ФЕО 1</div>
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="breath_feo"
                                                    wire:model.defer="item.breath_feo"
                                                    wire:loading.attr="disabled"
                                            />
                                            <div class="mt-2">ml</div>
                                        </div>
                                    </x-app.table-column>
                                </tr>
                                <tr>
                                    <x-app.table-column>
                                        <div class="flex space-x-3 items-center">
                                            <div class="mt-2 whitespace-nowrap">Показател на Тифно</div>
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="breath_tifno"
                                                    wire:model.defer="item.breath_tifno"
                                                    wire:loading.attr="disabled"
                                                    class="w-48"
                                            />
                                        </div>
                                    </x-app.table-column>
                                </tr>
                            </x-app.table>
                        </div>

                        <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
                            <x-app.table>
                                <x-slot:header>
                                    <x-app.table-th>Тонална аудиометрия</x-app.table-th>
                                </x-slot:header>
                                <tr>
                                    <x-app.table-column>
                                        <div class="flex space-x-3 items-center">
                                            <div class="mt-2 whitespace-nowrap">Загуба на слуха</div>
                                            <x-app.select
                                                    id="hearing_loss_id"
                                                    wire:model.defer="item.hearing_loss_id"
                                                    wire:loading.attr="disabled"
                                            >
                                                <option value="">{{ __('Choose...') }}</option>
                                                @foreach(\App\Models\HearingLoss::dropdown() as $key => $val)
                                                    <option value="{{ $key }}">{{ $val }}</option>
                                                @endforeach
                                            </x-app.select>
                                        </div>
                                    </x-app.table-column>
                                </tr>
                                <tr>
                                    <x-app.table-column>
                                        <div class="flex space-x-3 items-center">
                                            <div class="mt-2 whitespace-nowrap">Ляво ухо</div>
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="left_ear"
                                                    wire:model.defer="item.left_ear"
                                                    wire:loading.attr="disabled"
                                            />
                                            <div class="ml-3 mt-2 whitespace-nowrap">Дясно ухо</div>
                                            <x-app.input
                                                    type="number"
                                                    step="any"
                                                    id="right_ear"
                                                    wire:model.defer="item.right_ear"
                                                    wire:loading.attr="disabled"
                                            />
                                        </div>
                                    </x-app.table-column>
                                </tr>
                                <tr>
                                    <x-app.table-column>
                                        <div class="flex space-x-3 items-center">
                                            <div class="mt-2 whitespace-nowrap">Диагноза</div>
                                            <x-app.input
                                                    type="text"
                                                    id="tone_audiometry"
                                                    wire:model.defer="item.tone_audiometry"
                                                    wire:loading.attr="disabled"
                                            />
                                        </div>
                                    </x-app.table-column>
                                </tr>
                            </x-app.table>
                        </div>

                    </div>

                    <div>
                        <div>
                            <x-input-label for="electrocardiogram">ЕКГ</x-input-label>
                            <x-app.textarea
                                    id="electrocardiogram"
                                    wire:model.defer="item.electrocardiogram"
                                    wire:loading.attr="disabled"
                                    placeholder="ЕКГ"
                            />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="x_ray">Рентгенография</x-input-label>
                            <x-app.textarea
                                    id="x_ray"
                                    wire:model.defer="item.x_ray"
                                    wire:loading.attr="disabled"
                                    placeholder="Рентгенография"
                            />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="echo_ray">Ехография</x-input-label>
                            <x-app.textarea
                                    id="echo_ray"
                                    wire:model.defer="item.echo_ray"
                                    wire:loading.attr="disabled"
                                    placeholder="Ехография"
                            />
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
